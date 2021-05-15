var Modelo = 'm1';
var ComMusica = 0;
var MusicaDoYt = 0;
var ComIma = 0;
var ComLegenda = 0;
var LinkMusicaEscolhida = "abc";
var LegendaDaFoto = "abc";
var ImagemDaFoto = "abc";
var ProductTypeFromURL = "abc";
var ProductType2FromURL = "abc";
var ProductNameFromURL = "abc";

function processUser()
{
    var urlRef = new URL(window.location.href);
    ProductNameFromURL = urlRef.searchParams.get("ProductNameRef");
    ProductTypeFromURL = urlRef.searchParams.get("ProductType1Ref");
    ProductType2FromURL = urlRef.searchParams.get("ProductType2Ref");
}

// Creating array of photos
let ArrayPhoto = [
    {
        ModeloFoto: "m1",
        TemMusica: 0,
        MusicaVemDoYt: 0,
        TemIma: 0,
        TemLegenda: 0,
        LinkMusica: "abc",
        LegendaFoto: "abc",
        ImagemFoto: "abc",
    },
];

function AdicionarFoto()
{
    if(ImagemDaFoto !== "abc")
    {
        ColocarFoto(Modelo, ComMusica, MusicaDoYt, ComIma, ComLegenda, LinkMusicaEscolhida, LegendaDaFoto, ImagemDaFoto);
        ResetPhoto();
        UpdateCreatedPhotos();
        var URLToTravel = "Carrinho.html?ProductNameRef="+ProductNameFromURL+"&ProductType1Ref="+ProductTypeFromURL+"&ProductType2Ref="+ProductType2FromURL;
        var i = 0;
        var NumberOfPhotos = 10;
        if(ProductTypeFromURL == '10 fotos')
            NumberOfPhotos = 10;
        else if(ProductTypeFromURL == '20 fotos')
            NumberOfPhotos = 20;
        else
            NumberOfPhotos = 30;

        if((ArrayPhoto.length-1) == NumberOfPhotos-8)
        {
            localStorage.setItem("PhotosInfo", JSON.stringify(ArrayPhoto));
            //window.location.href = URLToTravel;
        }
    }
}

function ColocarFoto(ModeloFoto, TemMusica, MusicaVemDoYt, TemIma, TemLegenda, LinkMusica, LegendaFoto, ImagemFoto)
{
    ArrayPhoto.push({ModeloFoto, TemMusica, MusicaVemDoYt, TemIma, TemLegenda, LinkMusica, LegendaFoto, ImagemFoto});
}

function ResetPhoto()
{
    ComMusica = 0;
    MusicaDoYt = 0;
    ComLegenda = 0;
    ComImage = 0;
    LinkMusicaEscolhida = "abc";
    LegendaDaFoto = "abc";
    document.getElementById('musicacb').checked = false;
    document.getElementById('legendacb').checked = false;
    document.getElementById('imacb').checked = false;
    ToggleCheckBox('musicacb');
    ToggleCheckBox('legendacb');
    SetModelo('m1');
    document.getElementById('previewimage').style.display = "none";
    SetPreviewImage("abc");
}

function ToggleHideElement(id) {
var Elem = document.getElementById(id);
if (Elem.style.display === "none") {
    Elem.style.display = "block";
} else {
    Elem.style.display = "none";
}
}

function SetElemText(id, text) {
    document.getElementById(id).textContent = text;
}

function UnHideUploadPhotoPage() {
    ToggleHideElement('models');
    ToggleHideElement('uploadphoto');
}

function ToggleIma()
{
    if(ComIma) { ComIma = 0; }
    else { ComIma = 1; }
}

function ToggleCheckBox(id) {
    var Elem = document.getElementById(id);
    if(Elem.checked === true)
    {
        if(id === 'musicacb')
        {
            document.getElementById('legendacb').checked = false;
            ComLegenda = 0;
            ComMusica = 1;
            document.getElementById('legendatb').style.display = "none";
            document.getElementById('legendatblabel').style.display = "none";
            document.getElementById('linkmusicatb').style.display = "inline";
            document.getElementById('linkmusicatblabel').style.display = "inline";
            SetupLegendaPreview();
            SetupMusicaPreview();
        }
        else if (id === 'legendacb')
        {
            document.getElementById('musicacb').checked = false;
            ComMusica = 0;
            ComLegenda = 1;
            SetupMusicaPreview();
            SetupLegendaPreview();
            document.getElementById('legendatb').style.display = "inline";
            document.getElementById('legendatblabel').style.display = "inline";
            document.getElementById('linkmusicatb').style.display = "none";
            document.getElementById('linkmusicatblabel').style.display = "none";
        }
        else if (id === 'ytcb')
        {
            MusicaDoYt = 1;
            document.getElementById('spotifycb').checked = false;
            SetupMusicaPreview();
        }
        else if (id === 'spotifycb')
        {
            MusicaDoYt = 0;
            document.getElementById('ytcb').checked = false;
            SetupMusicaPreview();
        }
    }
    else
    {
        if(id === 'musicacb')
        {
            ComMusica = 0;
            document.getElementById('linkmusicatb').style.display = "none";
            document.getElementById('linkmusicatblabel').style.display = "none";
            SetupMusicaPreview();
        }
        else if (id === 'legendacb')
        {
            ComLegenda = 0;
            document.getElementById('legendatb').style.display = "none";
            document.getElementById('legendatblabel').style.display = "none";
            SetupLegendaPreview();
        }
    }
}

function SetModelo(id) {
    Modelo = id;
    SetModeloResultado();
}

function SetModeloResultado()
{
    if(Modelo === 'm1')
    {
        document.getElementById('basepreview').src = "Images/Modelos/Modelo1Separado.png";
        document.getElementById('basepreview').width = "449";
        document.getElementById('basepreview').height = "507.5";
        document.getElementById('previewimage').width = "372";
        document.getElementById('previewimage').height = "372";
        document.getElementById('previewimage').style.top = "40px";
        document.getElementById('previewimage').style.left = "38px";
        SetupLegendaPreview();
    }
    else
    {
        document.getElementById('basepreview').src = "Images/Modelos/Modelo2Separado.png";
        document.getElementById('basepreview').width = "449";
        document.getElementById('basepreview').height = "681.7";
        document.getElementById('previewimage').width = "355";
        document.getElementById('previewimage').height = "480";
        document.getElementById('previewimage').style.top = "44px";
        document.getElementById('previewimage').style.left = "44px";
        SetupLegendaPreview();
    }
}

function SetPreviewImage(srcToSet)
{
    ImagemDaFoto = srcToSet;
}

function SetupLegendaPreview()
{
    if(document.getElementById('legendacb').checked === true)
        document.getElementById('previewlegenda').style.display = "block";
    else
        document.getElementById('previewlegenda').style.display = "none";
    if(Modelo === "m1")
        document.getElementById('previewlegenda').style.bottom = "20px";
    else
        document.getElementById('previewlegenda').style.bottom = "50px";

    var LegendaWidth = document.getElementById('previewlegenda').getBoundingClientRect().width;
    var CurrentImageWidth = document.getElementById('previewimage').width;
    document.getElementById('previewlegenda').style.left = CurrentImageWidth/2 - LegendaWidth/4;
    LegendaDaFoto = document.getElementById('previewlegenda').innerHTML;
}

function SetupMusicaPreview()
{
    if(document.getElementById('musicacb').checked === false)
    {        
        document.getElementById('ytcb').style.display = "none"; 
        document.getElementById('ytlb').style.display = "none"; 
        document.getElementById('spotifycb').style.display = "none"; 
        document.getElementById('spotifylb').style.display = "none"; 
        if(Modelo === "m1")
            document.getElementById('basepreview').src = "Images/Modelos/Modelo1Separado.png";
        else
            document.getElementById('basepreview').src = "Images/Modelos/Modelo2Separado.png";
    }
    else
    {     
        document.getElementById('ytcb').style.display = "inline"; 
        document.getElementById('ytlb').style.display = "inline"; 
        document.getElementById('spotifycb').style.display = "inline"; 
        document.getElementById('spotifylb').style.display = "inline"; 
        if(document.getElementById('ytcb').checked === true)
        {   
            if(Modelo === "m1")
                document.getElementById('basepreview').src = "Images/Modelos/Modelo1yt.png";
            else
                document.getElementById('basepreview').src = "Images/Modelos/Modelo2yt.png";
        }
        else if(document.getElementById('spotifycb').checked === true)
        {   
            if(Modelo === "m1")
                document.getElementById('basepreview').src = "Images/Modelos/Modelo1spotfy.png";
            else
                document.getElementById('basepreview').src = "Images/Modelos/Modelo2spotfy.png";
        }
    }
        
}

function ChangeTextBox(id)
{
    if(id === "linkmusicatb")
    {
        LinkMusicaEscolhida = document.getElementById(id).value;
    }
    else if(id === "legendatb")
    {
        document.getElementById('previewlegenda').innerHTML = document.getElementById(id).value;
        SetupLegendaPreview();
    }
}

// Remove photo function handle
invoke = (event) => {
    let PhotoIDRef = event.target.getAttribute('name');
    ArrayPhoto.splice(parseInt(PhotoIDRef[6]), 1);
    document.getElementById('photos-content').removeChild(document.getElementById(PhotoIDRef));
}

function UpdateCreatedPhotos()
{

    // Pegando o div que segura as fotos
    const PhotoContent = document.getElementById('photos-content');

    // Limpando todos as fotos atuais
    while (PhotoContent.lastElementChild) 
    {
        PhotoContent.removeChild(PhotoContent.lastElementChild);
    }

    // Atribuindo as fotos para o modal
    var i;
    var NewPhotoAdded;
    var NewPhotoImage;
    var NewPhotoModel;
    var NewLegendaAdded;
    var LegendaText;
    var NewButtonDeletePhoto;
    for(i=1;i<ArrayPhoto.length;i++)
    {
        // Criando span base
        NewPhotoAdded = document.createElement("span");
        NewPhotoAdded.id = "SpanID"+i;
        NewPhotoAdded.style.display = "inline";

        // Criando imagem
        NewPhotoImage = document.createElement("img");
        NewPhotoImage.src = ArrayPhoto[i].ImagemFoto;
        NewPhotoImage.style.paddingTop = 10;
        NewPhotoAdded.appendChild(NewPhotoImage);

        // Botao remover foto
        NewButtonDeletePhoto = document.createElement('input');
        NewButtonDeletePhoto.type = "button";
        NewButtonDeletePhoto.name = NewPhotoAdded.id;
        NewButtonDeletePhoto.value = "Remover foto";
        NewButtonDeletePhoto.onclick = invoke;
        NewButtonDeletePhoto.style.marginTop = 170;
        NewButtonDeletePhoto.style.zIndex = 1;
        NewPhotoAdded.appendChild(NewButtonDeletePhoto);

        // Criando modelo
        NewPhotoModel = document.createElement("img");
        if(ArrayPhoto[i].ModeloFoto === 'm1')
        {
            NewButtonDeletePhoto.className = "ButtonRemovePhoto";
            NewButtonDeletePhoto.style.left = 55 + (i-1)*150;
            NewPhotoImage.style.left = 41 + (i-1)*150;
            NewPhotoModel.style.left = 30 + (i-1)*150;
            if(ArrayPhoto[i].TemMusica)
            {
                if(ArrayPhoto[i].MusicaVemDoYt)
                    NewPhotoModel.src = "Images/Modelos/Modelo1yt.png";
                else
                    NewPhotoModel.src = "Images/Modelos/Modelo1spotfy.png";
            }
            else
                NewPhotoModel.src = "Images/Modelos/Modelo1Separado.png";
                
            NewPhotoImage.className = "ImagePhotoAddedM1";
            NewPhotoModel.className = "PhotoAddedM1";
        }
        else
        {
            NewButtonDeletePhoto.className = "ButtonRemovePhoto";
            NewButtonDeletePhoto.style.left = 55 + (i-1)*150;
            NewPhotoImage.style.left = 61 + (i-1)*150;
            NewPhotoModel.style.left = 50 + (i-1)*150;
            if(ArrayPhoto[i].TemMusica)
            {
                if(ArrayPhoto[i].MusicaVemDoYt)
                    NewPhotoModel.src = "Images/Modelos/Modelo2yt.png";
                else
                    NewPhotoModel.src = "Images/Modelos/Modelo2spotfy.png";
            }
            else
                NewPhotoModel.src = "Images/Modelos/Modelo2Separado.png";
                
            NewPhotoImage.className = "ImagePhotoAddedM2";
            NewPhotoModel.className = "PhotoAddedM2";
        }
        NewPhotoAdded.appendChild(NewPhotoModel);

        // Criando legenda
        if(ArrayPhoto[i].TemLegenda)
        {
            NewLegendaAdded = document.createElement("h1");
            NewLegendaAdded.className = "LegendaPhotoAdded";
            NewLegendaAdded.innerHTML = ArrayPhoto[i].LegendaFoto;
            
            NewLegendaAdded.style.display = "block";
            var LegendaWidth = NewLegendaAdded.getBoundingClientRect().width;
            if(ArrayPhoto[i].ModeloFoto === "m1")
                NewLegendaAdded.style.top = "430px";
            else
                NewLegendaAdded.style.bottom = "50px";
            NewLegendaAdded.style.left = 372/2 - LegendaWidth/4 + (i-1)*450;

            NewPhotoAdded.appendChild(NewLegendaAdded);
        }

        // Adicionando tudo ao modal
        PhotoContent.appendChild(NewPhotoAdded);
    }
}