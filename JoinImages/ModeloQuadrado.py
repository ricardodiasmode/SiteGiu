try:
    from PIL import Image
except ImportError:
    import Image
from PIL import ExifTags
import sys

# sys.argv[1] = modelo
# sys.argv[2] = imagem 1
# sys.argv[3] = imagem 2

size = 735, 735

ModeloRef = Image.open("ModeloRef.png")
ModeloRef = ModeloRef.convert("RGBA")

ImageArray = []
for i in range(2):
    # Abrindo imagem
    try:
        ImageRef = Image.open("Imagem" + str(i+1) + "Ref.png")
    except FileNotFoundError:
        try:
            ImageRef = Image.open("Imagem" + str(i+1) + "Ref.jpeg")
        except FileNotFoundError:
            ImageRef = Image.open("Imagem" + str(i+1) + "Ref.jpg")
    ImageArray.insert(i, ImageRef)

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

ModeloRef.paste(ImageArray[0], (161, 226))
ModeloRef.paste(ImageArray[1], (1067, 226))
ModeloRef.save("new.png", "PNG")
