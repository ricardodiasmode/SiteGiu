var ProductTypeFromURL = "none";
var ProductType2FromURL = "none";
var ProductNameFromURL = "none";

// Creating array of photos
let ArrayPhoto = [
    {
        ModeloFoto: "m1",
        TemMusica: 0,
        MusicaVemDoYt: 0,
        TemIma: 0,
        TemLegenda: 0,
        LinkMusica: "none",
        LegendaFoto: "none",
        ImagemFoto: "none",
    },
];

function processUser()
{
    var urlRef = new URL(window.location.href);
    ProductNameFromURL = urlRef.searchParams.get("ProductNameRef");
    ProductTypeFromURL = urlRef.searchParams.get("ProductType1Ref");
    ProductType2FromURL = urlRef.searchParams.get("ProductType2Ref");
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
