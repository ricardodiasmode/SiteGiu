from PIL import Image, ImageFont, ImageDraw, ImageOps
from pathlib import Path
import glob
import os


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

# Pegando Modelos e adicionando ao array
ModelosArray = []
for i in range(len(ImagePropertiesArray)):
    # Verifica qual modelo eh
    if ImagePropertiesArray[i][1] == "t1":
        NomeArquivoModelo = "ModeloTirinha3.png"
        CodigoModeloAtual = "t1"
    else:
        NomeArquivoModelo = "ModeloTirinha4.png"
        CodigoModeloAtual = "t2"
    # Checa se o array de modelos esta vazio
    if len(ModelosArray) > 0:
        # Percorre o array em busca de uma posicao com modelo equivalente e posicao vazia
        for j in range(len(ModelosArray)):
            Added = False
            if ModelosArray[j][1] == CodigoModeloAtual:
                if CodigoModeloAtual == "t1":
                    RangeMax = 8
                else:
                    RangeMax = 10
                for k in range(2, RangeMax):
                    print("Para o modelo: "+str(j)+" / Checando posicao: "+str(k)+", de valor: "+str(ModelosArray[j][k]))
                    if ModelosArray[j][k] is None:
                        ModelosArray[j][k] = i
                        Added = True
                        print("Adicionou.")
                        break
                    else:
                        print("Não adicionou.")
            # Se nao houver posicao vazia, ou nao houver posicao com o mesmo modelo, cria uma
            if ModelosArray[j] == ModelosArray[len(ModelosArray) - 1] and Added is False:
                if CodigoModeloAtual == "t1":
                    ModelosArray.append([Image.open(NomeArquivoModelo), CodigoModeloAtual, i, None, None, None, None, None])
                else:
                    ModelosArray.append([Image.open(NomeArquivoModelo), CodigoModeloAtual, i, None, None, None, None, None, None, None])
                ModelosArray[len(ModelosArray) - 1][0] = (ModelosArray[len(ModelosArray) - 1][0].convert("RGBA"))
    # Se o array de modelos esta vazio, adiciona uma primeira posicao
    else:
        if CodigoModeloAtual == "t1":
            ModelosArray.append([Image.open(NomeArquivoModelo), CodigoModeloAtual, i, None, None, None, None, None])
        else:
            ModelosArray.append([Image.open(NomeArquivoModelo), CodigoModeloAtual, i, None, None, None, None, None, None, None])
        ModelosArray[len(ModelosArray) - 1][0] = ModelosArray[len(ModelosArray) - 1][0].convert("RGBA")

# Corrigindo rotacao
i = 0
for ImageRef in ImageArray:
    ImageObjRef = Image.open(ImageRef)
    # Corrigindo rotacao
    ImageObjRef = ImageOps.exif_transpose(ImageObjRef)
    # Corrigindo tamanho
    if ImagePropertiesArray[i][1] == "t1":
        ImageObjRef = ImageObjRef.resize((520, 520), Image.ANTIALIAS)
    else:
        ImageObjRef = ImageObjRef.resize((465, 465), Image.ANTIALIAS)
    # Convertendo para RGBA
    ImageObjRef = ImageObjRef.convert("RGBA")
    ImageObjRef.save(ImageRef)
    i += 1

i = 0
j = 0
k = 0
for k in range(len(ModelosArray)):
    for i in range(len(ImageArray)):
        for j in range(len(ModelosArray[k])):
            if i == ModelosArray[k][j]:
                # Pegando localizacao da imagem
                if j == 2:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 400)
                    else:
                        ImagePos = (200, 400)
                elif j == 3:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 500)
                    else:
                        ImagePos = (200, 500)
                elif j == 4:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 600)
                    else:
                        ImagePos = (200, 600)
                elif j == 5:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 700)
                    else:
                        ImagePos = (200, 700)
                elif j == 6:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 800)
                    else:
                        ImagePos = (200, 800)
                elif j == 7:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 900)
                    else:
                        ImagePos = (200, 900)
                elif j == 8:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 1000)
                    else:
                        ImagePos = (200, 1000)
                else:
                    if ImagePropertiesArray[i][1] == "t1":
                        ImagePos = (200, 1100)
                    else:
                        ImagePos = (200, 1100)
                # Abrindo a imagem
                ImageObjAux = Image.open(ImageArray[i])
                ModelosArray[k][0].paste(ImageObjAux, ImagePos)
                ImageNewName = ImagePropertiesArray[i][0] + ImagePropertiesArray[i][2]
                break
    ModelosArray[k][0].save(ImageNewName + ".png", "PNG")

