from PIL import Image, ExifTags, ImageFont, ImageDraw
from pathlib import Path
import sys
import glob
import os
import requests
import qrcode

# f = open("guru99.txt", "w+")


def GetMusicLinkById(UniqueId, ArrayOfLinks):
    for index in range(len(ArrayOfLinks)):
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

# TODO: Abrir um cmd que pergunta o nome do cliente
# Pegando o nome do cliente. Formato do nome da foto: NomeCliente_Modelo_ComMusica_DoYoutube_ComLegenda_Legenda=_LegendaPassada_IdUnico
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
    # TODO: Colocar dois id's em cada tupla, que sao os index da imagem respectiva do ImagePropertiesArray,
    # que corresponde a imagem no array ImageArray
    if j[1] == "m1":
        # Checa se o array esta vazio
        if len(ModelosArray) > 0:
            # Percorre o array em busca de uma posicao com modelo equivalente e posicao vazia
            for ModeloRef in ModelosArray:
                if ModeloRef[1] == 0 and ModeloRef[2] == "m1":
                    ModeloRef[1] = 1
                else:
                    # Se nao houver posicao vazia, ou nao houver posicao com o mesmo modelo, cria uma
                    if ModeloRef == ModelosArray[len(ModelosArray)-1]:
                        ModelosArray.append((Image.open("ModeloQuadrado.png"), 0, "m1"))
        # Se o array esta vazio, adiciona uma primeira posicao
        else:
            ModelosArray.append((Image.open("ModeloQuadrado.png"), 0, "m1"))
        SizeArray.append((735, 735))
        ImagePos1Array.append((161, 226))
        ImagePos2Array.append((1067, 226))
    else:
        # Checa se o array esta vazio
        if len(ModelosArray) > 0:
            # Percorre o array em busca de uma posicao com modelo equivalente e posicao vazia
            for ModeloRef in ModelosArray:
                if ModeloRef[1] == 0 and ModeloRef[2] == "m1":
                    ModeloRef[1] = 1
                else:
                    # Se nao houver posicao vazia, ou nao houver posicao com o mesmo modelo, cria uma
                    if ModeloRef == ModelosArray[len(ModelosArray)-1]:
                        ModelosArray.append((Image.open("ModeloRetangular.png"), 0, "m2"))
        # Se o array esta vazio, adiciona uma primeira posicao
        else:
            ModelosArray.append((Image.open("ModeloRetangular.png"), 0, "m2"))
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
        LegendaFoto = j[6]
        # TODO: Em vez de colocar a legenda na imagem, trocar para colocar no modelo
        # Convert our image into an editable format
        ImageObj = Image.open(ImageArray[i])
        DrawImage = ImageDraw.Draw(ImageObj)
        ImagePosition = (15, 15)
        ImageColor = (0, 0, 0)
        DrawImage.text(ImagePosition, LegendaFoto, ImageColor, font=FontLegenda)
        ImageObj.save(ImageArray[i])
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
            ImageObjRef = Image.open(ImageRef)
            ImageObjRef = ImageObjRef.resize(SizeArray[i], Image.ANTIALIAS)
            ImageObjRef = ImageObjRef.convert("RGBA")
            ImageObjRef.save(ImageRef)
        except AttributeError:
            # Tratando imagem
            ImageObjRef = Image.open(ImageRef)
            ImageObjRef = ImageObjRef.resize(SizeArray[i], Image.ANTIALIAS)
            ImageObjRef = ImageObjRef.convert("RGBA")
            ImageObjRef.save(ImageRef)
    i += 1

i = 0
for ModeloRef in ModelosArray:
    ImageObjAux = Image.open(ImageArray[i])
    ModeloRef.paste(ImageObjAux, ImagePos1Array[i])
    i += 1
    ModeloRef.paste(ImageObjAux, ImagePos2Array[i])
    ModeloRef.save(ImageNewName + ".png", "PNG")

LinkMusicasFile.close()
