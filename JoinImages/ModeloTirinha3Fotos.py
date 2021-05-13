try:
    from PIL import Image
except ImportError:
    import Image
from PIL import ExifTags

size = 515, 515

ModeloRef = Image.open("ModeloRef.png")
ModeloRef = ModeloRef.convert("RGBA")

ImageArray = []
for i in range(6):
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

ModeloRef.paste(ImageArray[0], (278, 396))
ModeloRef.paste(ImageArray[1], (278, 984))
ModeloRef.paste(ImageArray[2], (278, 1568))
ModeloRef.paste(ImageArray[3], (984, 396))
ModeloRef.paste(ImageArray[4], (984, 984))
ModeloRef.paste(ImageArray[5], (984, 1573))
ModeloRef.save("new.png", "PNG")
