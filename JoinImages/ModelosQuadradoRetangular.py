from PIL import Image, ExifTags, ImageFont, ImageDraw
from pathlib import Path
import sys
import glob
import os
import requests
import qrcode


def GetMusicLinkById(UniqueId, ArrayOfLinks):
    for index in range(ArrayOfLinks):
        ArrayParseado = ArrayOfLinks[index].split(":")
        if ArrayParseado[0] == UniqueId:
            return ArrayParseado[1]


def GetSpotifyImage(LinkMusicaCompleto):
    # Format: https://scannables.scdn.co/uri/plain/[format]/[background - color - in -hex]/[code - color - in -text] / [size] / [spotify - URI]
    UrlBase = "https://scannables.scdn.co/uri/plain/png/000000/white/320/spotify:track:"
    # Tratando o link da musica
    LinkDaMusicaSplitted = LinkMusicaCompleto.split("/")
    LinkDaMusicaSplittedAgain = LinkDaMusicaSplitted[1].split("?")
    LinkDaMusicaTratado = LinkDaMusicaSplittedAgain[0]
    # Criando a onda spotify
    SpotifyImageURL = UrlBase + LinkDaMusicaTratado
    return Image.open(requests.get(SpotifyImageURL, stream=True).raw)


def GetYoutubeImage(LinkMusicaCompleto):
    YoutubeQRCode = qrcode.QRCode(
        version=1,
        error_correction=qrcode.constants.ERROR_CORRECT_H,
        box_size=10,
        border=4,
    )
    YoutubeQRCode.add_data(LinkMusicaCompleto)
    YoutubeQRCode.make(fit=True)
    return YoutubeQRCode.make_image(fill_color="black", back_color="white").convert('RGB')


# Pegando a font da legenda, para caso haja uma
FontLegenda = ImageFont.truetype('rage-italic.ttf', 200)

# Pegando o nome do cliente. Formato do nome: NomeCliente_Modelo_ComMusica_DoYoutube_ComLegenda_Legenda=_LegendaPassada_IdUnico
ClientName = sys.argv[1]

# Mudando o diretorio de trabalho do programa depois de pegar a font da legenda
os.chdir("uploads")

ImageArray = []
ImagePropertiesArray = []
ImageNewName = ""
i = 0
# Pegando Imagens e adicionando ao array
for file in glob.glob("*.png"):
    ImageName = Path(file).stem
    ImageProperties = ImageName.split("_")
    if ImageProperties[0] == ClientName:
        ImageArray.append(file)
        # Definindo o novo nome da imagem como o NomeDoClient_IdUnico
        ImageNewName += ImageProperties[0] + "_" + ImageProperties[7]
        ImagePropertiesArray.append(ImageProperties)
    i += 1

# Pegando o link das musicas
LinkMusicasLines = []
with open('LinkMusicas.txt') as LinkMusicasFile:
    LinkMusicasLines = LinkMusicasFile.readlines()

# Pegando Modelos e adicionando ao array
ModelosArray = []
SizeArray = []
ImagePos1Array = []
ImagePos2Array = []
i = 0
for j in ImagePropertiesArray:
    # Verifica qual modelo eh
    if j[1] == "m1":
        ModelosArray[i] = Image.open("ModeloQuadrado.png")
        SizeArray.append((735, 735))
        ImagePos1Array.append((161, 226))
        ImagePos2Array.append((1067, 226))
    else:
        ModelosArray[i] = Image.open("ModeloRetangular.png")
        SizeArray.append((391, 526))
        ImagePos1Array.append((140, 99))
        ImagePos2Array.append((712, 93))
    ModelosArray[i] = ModelosArray[i].convert("RGBA")
    # Verifica se tem musica
    if j[2] == '1':
        # Verifica se a musica eh do spotify
        if j[3] == '0':
            LinkDaMusica = GetMusicLinkById(j[7], LinkMusicasLines)
            SpotifyImage = GetSpotifyImage(LinkDaMusica)
            SpotifyImageLocation = (200, 200)
            # Colocando imagem no modelo
            ModelosArray[i].paste(SpotifyImage, SpotifyImageLocation)
        # Se for do youtube
        else:
            LinkDaMusica = GetMusicLinkById(j[7], LinkMusicasLines)
            YoutubeQRCodeImage = GetYoutubeImage(LinkDaMusica)
            YoutubeImageLocation = (200, 200)
            # Colocando imagem no modelo
            ModelosArray[i].paste(YoutubeQRCodeImage, YoutubeImageLocation)
    # Se nao tem musica, verifica se tem legenda
    elif j[4] == '1':
        # Verifica qual modelo eh
        if j[1] == "m1":
            ModelosArray[i] = Image.open("ModeloQuadrado.png")
        else:
            ModelosArray[i] = Image.open("ModeloRetangular.png")
        LegendaFoto = j[6]
        # Convert our image into an editable format
        ImageArray[i] = ImageDraw.Draw(ImageArray[i])
        ImagePosition = (15, 15)
        ImageColor = (0, 0, 0)
        ImageArray[i].text(ImagePosition, LegendaFoto, ImageColor, font=FontLegenda)
    # Se nao tem musica nem legenda
    else:
        # Verifica qual modelo eh
        if j[1] == "m1":
            ModelosArray[i] = Image.open("ModeloQuadrado.png")
        else:
            ModelosArray[i] = Image.open("ModeloRetangular.png")
    i += 1

# Corrigindo rotacao
i = 0
for ImageRef in ImageArray:
    for orientation in ExifTags.TAGS.keys():
        if ExifTags.TAGS[orientation] == 'Orientation':
            break
        try:
            exif = dict(ImageRef._getexif().items())
            if exif[orientation] == 3:
                ImageRef = ImageRef.rotate(180, expand=True)
            elif exif[orientation] == 6:
                ImageRef = ImageRef.rotate(270, expand=True)
            elif exif[orientation] == 8:
                ImageRef = ImageRef.rotate(90, expand=True)
            # Tratando imagem
            ImageRef = ImageRef.resize(SizeArray[i], Image.ANTIALIAS)
            ImageRef = ImageRef.convert("RGBA")
        except AttributeError:
            # Tratando imagem
            ImageRef = ImageRef.resize(SizeArray[i], Image.ANTIALIAS)
            ImageRef = ImageRef.convert("RGBA")
    i += 1

i = 0
for ModeloRef in ModelosArray:
    ModeloRef.paste(ImageArray[i], ImagePos1Array[i])
    i += 1
    ModeloRef.paste(ImageArray[i], ImagePos2Array[i])
    ModeloRef.save(ImageNewName + ".png", "PNG")

LinkMusicasFile.close()
