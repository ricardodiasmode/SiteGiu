try:
    from PIL import Image
except ImportError:
    import Image

size = 740, 740

background = Image.open("ModeloRef.png")
overlay = Image.open("ImagemRef.png")

overlay = overlay.resize(size, Image.ANTIALIAS)

background = background.convert("RGBA")
overlay = overlay.convert("RGBA")

background.paste(overlay, (75, 80))
background.save("new.png","PNG")
