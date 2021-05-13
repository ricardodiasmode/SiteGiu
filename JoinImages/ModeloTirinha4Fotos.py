try:
    from PIL import Image
except ImportError:
    import Image
from PIL import ExifTags

size = 456, 459

ModeloRef = Image.open("ModeloRef.png")
ModeloRef = ModeloRef.convert("RGBA")

ImageArray = []
for i in range(8):
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

# Juntando imagens
ModeloRef.paste(ImageArray[0], (320, 211))
ModeloRef.paste(ImageArray[1], (320, 704))
ModeloRef.paste(ImageArray[2], (324, 1194))
ModeloRef.paste(ImageArray[3], (324, 1687))
ModeloRef.paste(ImageArray[4], (1004, 212))
ModeloRef.paste(ImageArray[5], (1001, 702))
ModeloRef.paste(ImageArray[6], (1005, 1195))
ModeloRef.paste(ImageArray[7], (1005, 1691))
ModeloRef.save("new.png", "PNG")
