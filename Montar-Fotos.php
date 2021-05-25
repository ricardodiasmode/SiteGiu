<script type="text/javascript" src="Montar-Fotos.js"></script>

<script>    
    var Modelo = 'm1';
    var ComMusica = 0;
    var MusicaDoYt = 0;
    var ComIma = 0;
    var ComLegenda = 0;
    var LinkMusicaEscolhida = "none";
    var LegendaDaFoto = "none";
    var ImagemDaFoto = "none"; 
    var ProductNameFromURL = "none";   
    var ProductTypeFromURL = "none";
    var ProductType2FromURL = "none";
    var IrParaCarrinho = "false";
    var NumeroFotosMontadas = "0";

    function processUser()
    {
        var urlRef = new URL(window.location.href);
        ProductNameFromURL = urlRef.searchParams.get("ProductNameRef");
        ProductTypeFromURL = urlRef.searchParams.get("ProductType1Ref");
        ProductType2FromURL = urlRef.searchParams.get("ProductType2Ref");
        IrParaCarrinho = urlRef.searchParams.get("IrParaCarrinho");
        NumeroFotosMontadas = urlRef.searchParams.get("NumeroFotosMontadas");
        window.history.replaceState({}, document.title, "/SiteGiu/" + "Montar-Fotos.php");
        CheckIrParaCarrinho();
    }    

    function CheckIrParaCarrinho()
    {
        if(IrParaCarrinho == 'true')
        {
            // Criando url do carrinho
            var URLToTravel = "Carrinho.php?ProductNameRef="+ProductNameFromURL+"&ProductType1Ref="+ProductTypeFromURL+"&ProductType2Ref="+ProductType2FromURL;
            // Indo para o carrinho
            window.location.href = URLToTravel;
        }
    }

    function CheckNumberOfPhotos()
    {
        var NumberOfPhotos = 10;
        if(ProductTypeFromURL == '10 fotos')
            NumberOfPhotos = 10;
        else if(ProductTypeFromURL == '20 fotos')
            NumberOfPhotos = 20;
        else
            NumberOfPhotos = 30;
        if(parseInt(NumeroFotosMontadas) >= NumberOfPhotos)
        {
            IrParaCarrinho = 'true';
            document.getElementById('AdicionarFotoForm').action = "Montar-Fotos.php?ProductNameRef="+ProductNameFromURL+"&ProductType1Ref="+ProductTypeFromURL+"&ProductType2Ref="+ProductType2FromURL+"&IrParaCarrinho="+IrParaCarrinho+"&NumeroFotosMontadas="+NumeroFotosMontadas;
            document.getElementById('AdicionarFotoForm').submit();
        }
        else
        {
            if(NumeroFotosMontadas == null)
                NumeroFotosMontadas = "1";
            else
            {   
                var auxint = parseInt(NumeroFotosMontadas);
                auxint = auxint+1;
                NumeroFotosMontadas = auxint.toString();
            }
            document.getElementById('AdicionarFotoForm').action = "Montar-Fotos.php?ProductNameRef="+ProductNameFromURL+"&ProductType1Ref="+ProductTypeFromURL+"&ProductType2Ref="+ProductType2FromURL+"&IrParaCarrinho="+IrParaCarrinho+"&NumeroFotosMontadas="+NumeroFotosMontadas;
            document.getElementById('AdicionarFotoForm').submit();
        }
    }

    function AdicionarFoto(ArrayPhotoRef)
    {
        if(ImagemDaFoto !== "none")
        {
            document.getElementById('ClientNamePassed').value = localStorage.getItem("ClientName");
            // Adicionando foto no array
            ArrayPhotoRef = {Modelo, ComMusica, MusicaDoYt, ComIma, ComLegenda, LinkMusicaEscolhida, LegendaDaFoto, ImagemDaFoto};
            // Definindo a foto no localStorage
            localStorage.setItem("PhotosInfo", JSON.stringify(ArrayPhotoRef));
            GetDataFormValues();
            // Verificando se alcançou o numero maximo de fotos
            CheckNumberOfPhotos(ArrayPhotoRef);
        }
    }

    // Variavel que segura as fotos ja criadas
    if(localStorage.getItem('PhotosInfo') != null)
        var PhotosInfo = JSON.parse(localStorage.getItem('PhotosInfo') || '{}');
    else
        var PhotosInfo = ArrayPhoto[ArrayPhoto.length-1];


    // Remove photo from folder
    function RemovePhotoFromFolder(){
        if(localStorage.getItem('ClientName') != null)
        {
            var ClientNameRef = localStorage.getItem('ClientName');
            $.ajax(
            {
                type: "GET",
                url: "RemovePhotoFromFolder.php",
                data: { ClientName: ClientNameRef },
                success: function(msg){
                    console.log(msg);
                }
            });
        }
    }

    // Remove photo from preview
    invoke = (event) => {
        let PhotoIDRef = event.target.getAttribute('name');
        localStorage.removeItem("PhotosInfo");
        document.getElementById('photos-content').removeChild(document.getElementById(PhotoIDRef));
        RemovePhotoFromFolder();
    }

    // Gerando preview das fotos criadas
    function UpdateCreatedPhotos(ArrayPhotoRef)
    {
        if(!ArrayPhotoRef)
            return;
        // Pegando o div que segura as fotos
        const PhotoContent = document.getElementById('photos-content');

        // Limpando todos as fotos atuais
        while (PhotoContent.lastElementChild) 
        {
            PhotoContent.removeChild(PhotoContent.lastElementChild);
        }

        // Atribuindo as fotos ao div
        var NewPhotoAdded;
        var NewPhotoImage;
        var NewPhotoModel;
        var NewLegendaAdded;
        var LegendaText;
        var NewButtonDeletePhoto;
        // Criando span base
        NewPhotoAdded = document.createElement("span");
        NewPhotoAdded.id = "SpanID";
        NewPhotoAdded.style.display = "inline";

        // Criando imagem
        NewPhotoImage = document.createElement("img");
        NewPhotoImage.src = ArrayPhotoRef.ImagemDaFoto;
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
        if(ArrayPhotoRef.Modelo === 'm1')
        {
            NewButtonDeletePhoto.className = "ButtonRemovePhoto";
            NewButtonDeletePhoto.style.left = 55;// + (i-1)*150;
            NewPhotoImage.style.left = 41;// + (i-1)*150;
            NewPhotoModel.style.left = 30;// + (i-1)*150;
            if(ArrayPhotoRef.ComMusica)
            {
                if(ArrayPhotoRef.MusicaDoYt)
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
            NewButtonDeletePhoto.style.left = 55;// + (i-1)*150;
            NewPhotoImage.style.left = 61;// + (i-1)*150;
            NewPhotoModel.style.left = 50;// + (i-1)*150;
            if(ArrayPhotoRef.ComMusica)
            {
                if(ArrayPhotoRef.MusicaDoYt)
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
        if(ArrayPhotoRef.ComLegenda)
        {
            NewLegendaAdded = document.createElement("h1");
            NewLegendaAdded.style.fontSize = 15;
            NewLegendaAdded.className = "LegendaPhotoAddedPreview";
            NewLegendaAdded.innerHTML = ArrayPhotoRef.LegendaDaFoto;
            NewLegendaAdded.zIndex = 3;
            if(ArrayPhotoRef.Modelo === "m1")
            {
                NewLegendaAdded.style.left = 80;// + (i-1)*150;
                NewLegendaAdded.style.marginTop = "140px";
            }
            else
            {
                NewLegendaAdded.style.left = 85;// + (i-1)*150;
                NewLegendaAdded.style.marginTop = "135px";
            }

            NewPhotoAdded.appendChild(NewLegendaAdded);
        }
        // Adicionando tudo ao div
        PhotoContent.appendChild(NewPhotoAdded);
    
    }
</script>

<?php
// TODO: Precaucoes: https://www.php.net/manual/en/function.move-uploaded-file.php

    if (isset($_POST['ModeloPassed']))
    {
        // Pegando IdUnico
        $IdFile = fopen("UniqueID.txt", "r+") or die("Unable to open file!");
        $IdUnico = ((int)fgets($IdFile))+1;
        fclose($IdFile);
        // Update no arquivo
        $IdFile = fopen("UniqueID.txt", "w") or die("Unable to open file!");
        fwrite($IdFile, $IdUnico);
        fclose($IdFile);
        $NomeCliente = $_POST['ClientNamePassed']."_".$_POST['ModeloPassed']."_".$_POST['ComMusicaPassed']."_".$_POST['MusicaYtPassed']."_".$_POST['ComLegendaPassed']."_"."Legenda="."_".$_POST['LegendaPassed']."_".$IdUnico.".png"; // file name
        if( move_uploaded_file($_FILES["PhotoToUpload"]["tmp_name"], "..\\SiteGiu\\JoinImages\\uploads\\".$NomeCliente) ) {
            echo 'File uploaded';
        } else {
            echo 'Something went wrong uploading file';
        }
        // Criando .txt com id e link da musica
        if (isset($_POST['LinkMusicaPassed']))
        {
            $pathToLinkMusicas = "D:\\xampp\\htdocs\\SiteGiu\\JoinImages\\uploads\\LinkMusicas.txt";
            $LinkMusicasFile = fopen($pathToLinkMusicas, "a");
            $txt = $IdUnico.":".$_POST['LinkMusicaPassed']."\n";
            fwrite($LinkMusicasFile, $txt);
            fclose($LinkMusicasFile);
        }
    }
?>

<script>
    function GetDataFormValues()
    {
        document.getElementById('ModeloPassed').value = Modelo;
        document.getElementById('ComMusicaPassed').value = ComMusica;
        document.getElementById('MusicaYtPassed').value = MusicaDoYt;
        document.getElementById('ComLegendaPassed').value = ComLegenda;
        document.getElementById('LinkMusicaPassed').value = LinkMusicaEscolhida;
        document.getElementById('LegendaPassed').value = LegendaDaFoto;
    }
</script>

<!doctype html>
<html lang="pt-BR">
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/jquery-ui.min.js"></script>
<head>
    <!-- Default content -->
    <style>
        @font-face { font-family: rage-italic; src: url('rage-italic.TTF'); } 
        h1 {
            font-family: rage-italic
        }
    </style>

    <style>
        .base-image {
            position: relative;
            top: 0;
            left: 0;
        }

        .image-previewm1__image {
            display: none;
            position: absolute;
            top: 40px;
            left: 38px;
        }
    </style>

    <!-- Photo preview style -->
    <style>
        /* Photo Added */
        .ButtonRemovePhoto
        {
            position: absolute;
            width: 100px;
            height: 25px;
        }
        .PhotoAddedM1
        {
            position: absolute;
            width: 150px;
            height: 169px;
        }
        .PhotoAddedM2
        {
            position: absolute;
            width: 110px;
            height: 168px;
        }

        .ImagePhotoAddedM1
        {
            display: block;
            position: absolute;
            width: 126px;
            height: 126px;
            
        }

        .ImagePhotoAddedM2
        {
            display: block;
            position: absolute;
            width: 92px;
            height: 123px;
        }

        .LegendaPhotoAdded
        {
            position: absolute;
            display: none;
        }

        .LegendaPhotoAddedPreview
        {
            display: block;
            position: absolute;
        }

        /* Modal */
        .modal {
            display: none;
            position: absolute;
            left: 50%;
            top: 50%;
            animation-name: animatetop;
            animation-duration: 0.4s;
            background-color: rgb(0, 0, 0);
            background-image: "url('Images/ModalBackgroundImage.jpg')";
            max-width: 450px;
            overflow-x: auto;
            overflow-y: hidden;
        }

        /* Add Animation */
        @keyframes animatetop {
        from {top: -300px; opacity: 0}
        to {top: 0; opacity: 1}
        }
    </style>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="site description" />
    <meta name="keywords" content="put here keyoword to find easy by google" />
</head>
<body style="background-image: url('Images/BackgroundImage.jpg')">
    <!-- Escolhendo modelos -->
    <div id="BaseDiv" style="display:flex">

        <span style="text-align: left; vertical-align: top;">
            <input onclick="SetModelo('m1')" type="image" src="Images/Modelos/Modelo1Separado.png" alt="Modelo1Img" style="width:449px;height:507.5px;" id="m1" />
        </span>

        <span style="text-align: center; vertical-align: top;">
            <img src="Images/Logo.png" alt="Our logo" style="width:400px;height:400px;" id="logo">
            
            <!-- Escolhendo se tem musica ou nao -->
            <p><input onclick="ToggleCheckBox('musicacb')" type="checkbox" id="musicacb" name="musicacb">
            <label for="musicacb">Com Musica?</label></p>

            <!-- Escolhendo se a musica vem do youtube -->
            <p><input onclick="ToggleCheckBox('ytcb')" style="display:none" type="checkbox" id="ytcb" name="ytcb">
            <label style="display:none" id="ytlb" for="ytcb">Do youtube?</label></p>
            
            <!-- Escolhendo se a musica vem do spotify -->
            <p><input onclick="ToggleCheckBox('spotifycb')" style="display:none" type="checkbox" id="spotifycb" name="spotifycb">
            <label style="display:none" id="spotifylb" for="spotifycb">Do spotify?</label></p>

            <!-- Escolhendo o link da musica -->
            <p><label for="linkmusicatb" style="display:none" id="linkmusicatblabel">Cole o link da musica: </label>
            <input onchange="ChangeTextBox('linkmusicatb')" type="text" id="linkmusicatb" name="linkmusicatb" style="display:none;"></p>
            
            <!-- Escolhendo se tem legenda ou nao -->
            <p><input onclick="ToggleCheckBox('legendacb')" type="checkbox" id="legendacb" name="legendacb">
            <label for="legendacb">Com Legenda?</label></p>
           
            <!-- Escolhendo o texto da legenda -->
            <p><label for="legendatb" style="display:none" id="legendatblabel">Digite a legenda: </label>
            <input onchange="ChangeTextBox('legendatb')" type="text" maxlength="15" id="legendatb" name="legendatb" style="display:none;"></p>
            
            <!-- Escolhendo se tem ima ou nao -->
            <p><input onclick="ToggleIma()" type="checkbox" id="imacb" name="imacb">
            <label for="imacb">Com Imã?</label></p>

            <!-- Fazendo o upload da foto -->
            <form action="Montar-Fotos.php" method="post" id="AdicionarFotoForm" enctype="multipart/form-data">
                <p id="NomeClienteParagrafo"><label for="ClientNamePassed" id="ClientNamePassedlabel">Seu Nome: </label></p>
                <script>
                    // Generate GUID
                    function uuidv4() {
                    return ([1e7]+-1e3+-4e3+-8e3+-1e11).replace(/[018]/g, c =>
                        (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                    );
                    }
                    // Set client name
                    SetNomeCliente = (event) => {
                        let ClientNameRef = document.getElementById('ClientNamePassed').value;
                        if (ClientNameRef == "")
                        {
                            localStorage.setItem("ClientName", "");
                            document.getElementById("AddPhotoButton").style.display = "none";
                            return;
                        }
                        if(localStorage.getItem('ClientName') == null)
                            ClientNameRef = ClientNameRef + uuidv4();
                        else
                            ClientNameRef = localStorage.getItem('ClientName');
                        localStorage.setItem("ClientName", ClientNameRef);
                        document.getElementById("AddPhotoButton").style.display = "inline-block";
                    }

                    if(localStorage.getItem('ClientName') == null || localStorage.getItem('ClientName') == "")
                    {
                        // Criando text box onde o cliente vai colocar o nome dele
                        var ClientNameTB = document.createElement("input");
                        ClientNameTB.type = "text";
                        ClientNameTB.id = "ClientNamePassed";
                        ClientNameTB.name = "ClientNamePassed";
                        ClientNameTB.onchange = SetNomeCliente;
                        document.getElementById("NomeClienteParagrafo").appendChild(ClientNameTB);
                    }
                    else
                    {
                        // Criando text box onde o cliente vai colocar o nome dele
                        var ClientNameTB = document.createElement("input");
                        ClientNameTB.type = "hidden";
                        ClientNameTB.id = "ClientNamePassed";
                        ClientNameTB.name = "ClientNamePassed";
                        ClientNameTB.value = localStorage.getItem('ClientName') + uuidv4();
                        document.getElementById("NomeClienteParagrafo").appendChild(ClientNameTB);
                        document.getElementById('ClientNamePassedlabel').remove();
                    }
                </script>
                <p>Escolha sua foto: <input type="file" value="Escolha sua foto" name="PhotoToUpload" id="PhotoToUpload"></p>
                <input type="hidden" name="ModeloPassed" id="ModeloPassed" value="none">
                <input type="hidden" name="ComMusicaPassed" id="ComMusicaPassed" value="none">
                <input type="hidden" name="MusicaYtPassed" id="MusicaYtPassed" value="none">
                <input type="hidden" name="ComLegendaPassed" id="ComLegendaPassed" value="none">
                <input type="hidden" name="LinkMusicaPassed" id="LinkMusicaPassed" value="none">
                <input type="hidden" name="LegendaPassed" id="LegendaPassed" value="none">
                <p><input onclick="AdicionarFoto(PhotosInfo);" style="display:none" type="button" name="AddPhotoButton" id="AddPhotoButton" value="Adicionar Foto"></p>
            <script>
                if(localStorage.getItem('ClientName') != null)
                    document.getElementById('AddPhotoButton').style.display = "inline-block";
            </script>
            </form>
            
            <!-- Preview das fotos feitas -->
            <p><div id="photos-content" style="display:flex;height: 200px;">
            <script>
                // Check se ha foto para ser adicionada ao preview
                if(localStorage.getItem('PhotosInfo') != null)
                {
                    UpdateCreatedPhotos(PhotosInfo);
                }
            </script>
            </div></p>

            <!-- Preview da foto atual -->
            <p>Como sua foto vai ficar: </p>
            <div class="base-image">
                <img src="" id='basepreview' width="449" height="507.5" class="base-image"/>
                <img src="" width="372" height="372" alt="Faça o upload para ver como sua foto vai ficar" class="image-previewm1__image" id="previewimage">
                <h1 id="previewlegenda" class="LegendaPhotoAdded">SuaLegenda</h1>
                <script>SetupLegendaPreview();</script>
            </div>
            <p>*resultado aproximado*</p>
            
            <!-- Definindo preview image -->
            <script>
                processUser();
                SetModeloResultado();
                // Setup image preview
                const PhotoFile = document.getElementById('PhotoToUpload');
                const PhotoImage = document.getElementById('previewimage');

                PhotoFile.addEventListener("change", function() 
                { 
                    const file = this.files[0];
                    if(file)
                    {
                        const reader = new FileReader();
                        
                        PhotoImage.style.display = "block";

                        reader.addEventListener("load" , function()
                        {
                            PhotoImage.setAttribute("src", this.result);
                            SetPreviewImage(this.result);
                        });

                        reader.readAsDataURL(file);
                    }
                    else
                    {
                        PhotoImage.style.display = "none";
                        SetPreviewImage('');
                    }
                });
            </script>
        </span>

        <span style="text-align: right; vertical-align: top;">
            <input onclick="SetModelo('m2')" type="image" src="Images/Modelos/Modelo2Separado.png" alt="Modelo2Img" style="width:393.6px;height:597.6px;" id="m2" />
        </span>
    </div>
</body>
</html>
