from PIL import Image, ImageFont, ImageDraw, ImageOps
from pathlib import Path
import glob
import os
import requests
import qrcode


def get_text_dimensions(text_string, font):
    # https://stackoverflow.com/a/46220683/9263761
    ascent, descent = font.getmetrics()

    text_width = font.getmask(text_string).getbbox()[2]
    text_height = font.getmask(text_string).getbbox()[3] + descent

    return text_width, text_height


def GetMusicLinkById(UniqueId, ArrayOfLinks):
    for index in range(len(ArrayOfLinks)):
        ArrayParseado = ArrayOfLinks[index].split(":")
        if ArrayParseado[0] == UniqueId:
            StringToReturn = ""
            for index2 in range(len(ArrayParseado)):
                if index2 != 0:
                    if ArrayParseado[index2] == ArrayParseado[len(ArrayParseado)-1]:
                        StringToReturn += ArrayParseado[index2]
                    else:
                        StringToReturn += ArrayParseado[index2]
                        StringToReturn += ":"
            return StringToReturn


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
        box_size=4,
        border=0,
    )
    YoutubeQRCode.add_data(LinkMusicaCompleto)
    YoutubeQRCode.make(fit=True)
    return YoutubeQRCode.make_image(fill_color="black", back_color="white").convert('RGB')


# Pegando o nome do cliente. Formato do nome da foto: NomeCliente_Modelo_ComMusica_DoYoutube_ComLegenda_Legenda=_LegendaPassada_IdUnico
ClientName = input('Digite o nome do cliente: ')

# Mudando o diretorio de trabalho do programa depois de pegar a font da legenda
os.chdir("uploads")

ImageArray = []
ImagePropertiesArray = []
# Pegando Imagens e adicionando ao array
for file in glob.glob("*.png"):
    ImageName = Path(file).stem
    ImageProperties = ImageName.split("_")
    if ImageProperties[0] == ClientName:
        ImageArray.append(file)
        ImagePropertiesArray.append(ImageProperties)

# Pegando o link das musicas
LinkMusicasLines = []
with open('LinkMusicas.txt') as LinkMusicasFile:
    LinkMusicasLines = LinkMusicasFile.readlines()

# Pegando Modelos e adicionando ao array
ModelosArray = []
for i in range(len(ImagePropertiesArray)):
    # Verifica qual modelo eh
    if ImagePropertiesArray[i][1] == "m1":
        # Checa se o array de modelos esta vazio
        if len(ModelosArray) > 0:
            # Percorre o array em busca de uma posicao com modelo equivalente e posicao vazia
            PosRef = 0
            for j in range(len(ModelosArray)):
                if ModelosArray[j][1] == 0 and ModelosArray[j][2] == "m1":
                    print('\nColocando a imagem de id: ' + str(i) + ' no array de modelos na pos: ' + str(PosRef))
                    ModelosArray[j] = (ModelosArray[j][0], 1, ModelosArray[j][2], ModelosArray[j][3], i)
                    break
                else:
                    # Se nao houver posicao vazia, ou nao houver posicao com o mesmo modelo, cria uma
                    if ModelosArray[j] == ModelosArray[len(ModelosArray) - 1]:
                        print(
                            '\nColocando a imagem de id: ' + str(i) + ' no array de modelos na pos: ' + str(PosRef + 1))
                        ModelosArray.append((Image.open("ModeloQuadrado.png"), 0, "m1", i, 0))
                        ModelosArray[len(ModelosArray) - 1] = (ModelosArray[len(ModelosArray) - 1][0].convert("RGBA"),
                                                               ModelosArray[len(ModelosArray) - 1][1],
                                                               ModelosArray[len(ModelosArray) - 1][2],
                                                               ModelosArray[len(ModelosArray) - 1][3],
                                                               ModelosArray[len(ModelosArray) - 1][4])
                        break
                PosRef = PosRef + 1
        # Se o array esta vazio, adiciona uma primeira posicao
        else:
            print('\nColocando a imagem de id: ' + str(i) + ' no array de modelos inicialmente')
            ModelosArray.append((Image.open("ModeloQuadrado.png"), 0, "m1", i, 0))
            ModelosArray[len(ModelosArray) - 1] = (ModelosArray[len(ModelosArray) - 1][0].convert("RGBA"),
                                                   ModelosArray[len(ModelosArray) - 1][1],
                                                   ModelosArray[len(ModelosArray) - 1][2],
                                                   ModelosArray[len(ModelosArray) - 1][3],
                                                   ModelosArray[len(ModelosArray) - 1][4])
    else:
        # Checa se o array esta vazio
        if len(ModelosArray) > 0:
            # Percorre o array em busca de uma posicao com modelo equivalente e posicao vazia
            for ModeloRef in ModelosArray:
                if ModeloRef[1] == 0 and ModeloRef[2] == "m1":
                    ModeloRef = (ModeloRef[0], 1, ModeloRef[2], ModeloRef[3], i)
                    break
                else:
                    # Se nao houver posicao vazia, ou nao houver posicao com o mesmo modelo, cria uma
                    if ModeloRef == ModelosArray[len(ModelosArray) - 1]:
                        ModelosArray.append((Image.open("ModeloRetangular.png"), 0, "m2", i, 0))
                        ModelosArray[len(ModelosArray) - 1] = (ModelosArray[len(ModelosArray) - 1][0].convert("RGBA"),
                                                               ModelosArray[len(ModelosArray) - 1][1],
                                                               ModelosArray[len(ModelosArray) - 1][2],
                                                               ModelosArray[len(ModelosArray) - 1][3],
                                                               ModelosArray[len(ModelosArray) - 1][4])
                        break
        # Se o array esta vazio, adiciona uma primeira posicao
        else:
            ModelosArray.append((Image.open("ModeloRetangular.png"), 0, "m2", i, 0))
            ModelosArray[len(ModelosArray) - 1] = (ModelosArray[len(ModelosArray) - 1][0].convert("RGBA"),
                                                   ModelosArray[len(ModelosArray) - 1][1],
                                                   ModelosArray[len(ModelosArray) - 1][2],
                                                   ModelosArray[len(ModelosArray) - 1][3],
                                                   ModelosArray[len(ModelosArray) - 1][4])

    # Verifica se tem musica
    if ImagePropertiesArray[i][2] == '1':
        # Verifica se a musica eh do spotify
        if ImagePropertiesArray[i][3] == '0':
            LinkDaMusica = GetMusicLinkById(ImagePropertiesArray[i][7], LinkMusicasLines)
            MusicImage = GetSpotifyImage(LinkDaMusica)
        # Se for do youtube
        else:
            LinkDaMusica = GetMusicLinkById(ImagePropertiesArray[i][7], LinkMusicasLines)
            MusicImage = GetYoutubeImage(LinkDaMusica)
        # Procurando Modelo da imagem
        for k in range(len(ModelosArray)):
            if ModelosArray[k][3] == i or ModelosArray[k][4] == i:
                # Colocando imagem da musica no modelo
                MusicImageWidth, MusicImageHeight = MusicImage.size
                if ModelosArray[k][2] == "m1":
                    # Vendo se esta na direita ou esquerda
                    if ModelosArray[k][3] == i:
                        MusicImageLocation = (int(534-(MusicImageWidth/2)), int(1040-(MusicImageHeight/2)))
                    else:
                        MusicImageLocation = (int(1432-(MusicImageWidth/2)), int(1040-(MusicImageHeight/2)))
                else:
                    # Vendo se esta na direita ou esquerda
                    if ModelosArray[k][3] == i:
                        MusicImageLocation = (int(339-(MusicImageWidth/2)), int(689-(MusicImageHeight/2)))
                    else:
                        MusicImageLocation = (int(910-(MusicImageWidth/2)), int(689-(MusicImageHeight/2)))
                ModelosArray[k][0].paste(MusicImage, MusicImageLocation)
                break
    # Se nao tem musica, verifica se tem legenda
    elif ImagePropertiesArray[i][4] == '1':
        LegendaFoto = ImagePropertiesArray[i][6]
        # Procurando Modelo da imagem
        for k in range(len(ModelosArray)):
            if ModelosArray[k][3] == i or ModelosArray[k][4] == i:
                # Convert our image into an editable format
                DrawImage = ImageDraw.Draw(ModelosArray[k][0])
                ImageColor = (0, 0, 0)

                # Pegando a font da legenda, para caso haja uma
                if ModelosArray[k][2] == "m1":
                    FontSize = 90
                else:
                    FontSize = 250
                FontLegenda = ImageFont.truetype('rage-italic.ttf', FontSize)

                # Pegando o tamanho do texto
                FontWidth, FontHeight = get_text_dimensions(LegendaFoto, FontLegenda)
                if ModelosArray[k][2] == "m1":
                    # Vendo se esta na direita ou esquerda
                    if ModelosArray[k][3] == i:
                        ImagePosition = (int(534-(FontWidth/2)), int(1040-(FontHeight/2)))
                    else:
                        ImagePosition = (int(1432-(FontWidth/2)), int(1040-(FontHeight/2)))
                else:
                    # Vendo se esta na direita ou esquerda
                    if ModelosArray[k][3] == i:
                        ImagePosition = (int(339-(FontWidth/2)), int(689-(FontHeight/2)))
                    else:
                        ImagePosition = (int(910-(FontWidth/2)), int(689-(FontHeight/2)))

                # De fato escrevendo a legenda
                DrawImage.text(ImagePosition, LegendaFoto, ImageColor, font=FontLegenda)
                break

# Corrigindo rotacao
i = 0
for ImageRef in ImageArray:
    ImageObjRef = Image.open(ImageRef)
    # Corrigindo rotacao
    ImageObjRef = ImageOps.exif_transpose(ImageObjRef)
    # Corrigindo tamanho
    if ImagePropertiesArray[i][1] == 'm1':
        ImageObjRef = ImageObjRef.resize((735, 735), Image.ANTIALIAS)
    else:
        ImageObjRef = ImageObjRef.resize((391, 526), Image.ANTIALIAS)
    # Convertendo para RGBA
    ImageObjRef = ImageObjRef.convert("RGBA")
    ImageObjRef.save(ImageRef)
    i += 1

i = 0
j = 0
k = 0
for ModeloRef in ModelosArray:
    # Searching for first image by id in the 3rd index
    for j in range(len(ImageArray)):
        print('\nProcurando primeiro id: ' + str(j))
        if j == ModeloRef[3]:
            print('\nId encontrado: ' + str(j))
            ImageObjAux = Image.open(ImageArray[j])
            # Searching for second image by id in the 4rd index
            for k in range(len(ImageArray)):
                print('\nProcurando segundo id: ' + str(k))
                if k == ModeloRef[4]:
                    print('\nId encontrado: ' + str(k))
                    Image2ObjAux = Image.open(ImageArray[k])
                    if ImagePropertiesArray[j][1] == "m1":
                        ImagePos1 = (161, 226)
                        ImagePos2 = (1067, 226)
                    else:
                        ImagePos1 = (140, 99)
                        ImagePos2 = (712, 93)

                    ModeloRef[0].paste(ImageObjAux, ImagePos1)
                    ModeloRef[0].paste(Image2ObjAux, ImagePos2)
                    ImageNewName = ImagePropertiesArray[j][0] + ImagePropertiesArray[j][7]
                    ModeloRef[0].save(ImageNewName + ".png", "PNG")
                    print('uma imagem salva')
                    break

LinkMusicasFile.close()
