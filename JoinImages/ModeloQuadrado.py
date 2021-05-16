try:
    from PIL import Image
    from PIL import ExifTags
except ImportError:
    import Image
    import ExifTags
try:
    from pathlib import Path
except ImportError:
    import Path
import sys
import glob
import os

# sys.argv[1] = nome do cliente
# Formato do nome: NomeCliente_Modelo_ComMusica_DoYoutube_ComLegenda_LinkMusica_Legenda=_LegendaPassada_IdUnico

# Mudando o diretorio de trabalho do programa
os.chdir("uploads")

# Pegando o nome do cliente
ClientName = sys.argv[1]

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
        ImageNewName.append(ImageProperties[0]+ImageProperties[8])
        ImagePropertiesArray.append(ImageProperties)
    # Corrigindo rotacao
    for orientation in ExifTags.TAGS.keys():
        if ExifTags.TAGS[orientation] == 'Orientation':
            break
    try:
        exif=dict(ImageArray[i]._getexif().items())
        if exif[orientation] == 3:
            ImageArray[i] = ImageArray[i].rotate(180, expand=True)
        elif exif[orientation] == 6:
            ImageArray[i] = ImageArray[i].rotate(270, expand=True)
        elif exif[orientation] == 8:
            ImageArray[i] = ImageArray[i].rotate(90, expand=True)
        # Tratando imagem
        ImageArray[i] = ImageArray[i].resize(size, Image.ANTIALIAS)
        ImageArray[i] = ImageArray[i].convert("RGBA")
    except AttributeError:
        # Tratando imagem
        ImageArray[i] = ImageArray[i].resize(size, Image.ANTIALIAS)
        ImageArray[i] = ImageArray[i].convert("RGBA")
    ++i

# Pegando Modelos e adicionando ao array
ModelosArray = []
SizeArray = []
Pos1Array = []
Pos2Array = []
for j in ImagePropertiesArray:
    # Verifica se tem musica
    if j[2] == '1':
        # Verifica qual modelo eh
        if j[1] == "m1":
            # Verifica se a musica eh do youtube
            if j[3] == '0':
                # TODO: Adiciona modelo com link do spotify
                ModeloRef = Image.open("ModeloQuadrado.png")
            else:
                # TODO: Adiciona modelo com link do youtube
                ModeloRef = Image.open("ModeloQuadrado.png")
            ModeloRef = ModeloRef.convert("RGBA")
            SizeArray.append((735, 735))
            Pos1Array.append((161, 226))
            Pos2Array.append((1067, 226))
        else:
            # Verifica se a musica eh do youtube
            if j[3] == '0':
                # TODO: Adiciona modelo com link do spotify
                # Use this URL:
                # https: // scannables.scdn.co / uri / plain / png / 000000 / white / 640 / spotify: playlist:0
                # qtAGoh3i4qOdw0pKaFjMz
                #
                # with this formatting:
                # https: // scannables.scdn.co / uri / plain / [format] / [background - color - in -hex] / [
                #     code - color - in -text] / [size] / [spotify - URI]
                ModeloRef = Image.open("ModeloRetangular.png")
            else:
                # TODO: Adiciona modelo com link do youtube
                ModeloRef = Image.open("ModeloRetangular.png")
            ModeloRef = ModeloRef.convert("RGBA")
            SizeArray.append((391, 526))
            Pos1Array.append((140, 99))
            Pos2Array.append((712, 93))
    # Se nao tem musica, verifica se tem legenda
    elif j[4] == '1':
        # Verifica qual modelo eh
        if j[1] == "m1":
            ModeloRef = Image.open("ModeloQuadrado.png")
        else:
            ModeloRef = Image.open("ModeloRetangular.png")
        LegendaFoto = j[7]
        # TODO: Adiciona legenda no modelo
    else:
        # Verifica qual modelo eh
        if j[1] == "m1":
            ModeloRef = Image.open("ModeloQuadrado.png")
        else:
            ModeloRef = Image.open("ModeloRetangular.png")

ModeloRef.paste(ImageArray[0], Pos1Array[0])
ModeloRef.paste(ImageArray[1], Pos1Array[0])
ModeloRef.save(ImageNewName+".png", "PNG")
