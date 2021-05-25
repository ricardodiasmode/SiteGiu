<script type="text/javascript" src="Montar-Tirinhas.js"></script>

<script>    
    var Modelo = 't1';
    var Imagem1DaFoto = "none"; 
    var Imagem2DaFoto = "none"; 
    var Imagem3DaFoto = "none"; 
    var Imagem4DaFoto = "none"; 
    var ProductNameFromURL = "none";   
    var ProductTypeFromURL = "none";
    var ProductType2FromURL = "none";
    var IrParaCarrinho = "false";
    var NumeroFotosMontadas = "0";
    var ImagesUploaded = [0, 0, 0, 0];

    function processUser()
    {
        var urlRef = new URL(window.location.href);
        ProductNameFromURL = urlRef.searchParams.get("ProductNameRef");
        ProductTypeFromURL = urlRef.searchParams.get("ProductType1Ref");
        ProductType2FromURL = urlRef.searchParams.get("ProductType2Ref");
        IrParaCarrinho = urlRef.searchParams.get("IrParaCarrinho");
        NumeroFotosMontadas = urlRef.searchParams.get("NumeroFotosMontadas");
        window.history.replaceState({}, document.title, "/SiteGiu/" + "Montar-Tirinhas.php");
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
        var MaxNumberOfPhotos = (ProductTypeFromURL == "Tirinha 3 fotos") ? 3 : 4;
        if((MaxNumberOfPhotos == 4 && ImagesUploaded[3]) || MaxNumberOfPhotos == 3)
        {
            if(ImagesUploaded[0] &&
               ImagesUploaded[1] &&
               ImagesUploaded[2])
            {
                IrParaCarrinho = 'true';
                document.getElementById('AdicionarFotoForm').action = "Montar-Tirinhas.php?ProductNameRef="+ProductNameFromURL+"&ProductType1Ref="+ProductTypeFromURL+"&ProductType2Ref="+ProductType2FromURL+"&IrParaCarrinho="+IrParaCarrinho+"&NumeroFotosMontadas="+NumeroFotosMontadas;
                document.getElementById('AdicionarFotoForm').submit();
            }
        }
    }

    function AdicionarFoto(ArrayPhotoRef)
    {
        document.getElementById('ClientNamePassed').value = localStorage.getItem("ClientName");
        Modelo = (ProductTypeFromURL == "Tirinha 3 fotos") ? "t1" : "t2";
        // Adicionando foto no array
        ArrayPhotoRef = {Modelo, Imagem1DaFoto, Imagem2DaFoto, Imagem3DaFoto, Imagem4DaFoto};
        // Definindo a foto no localStorage
        localStorage.setItem("PhotosInfo", JSON.stringify(ArrayPhotoRef));
        document.getElementById('ModeloPassed').value = Modelo;
        if(ArrayPhotoRef.Imagem1DaFoto != "none")
        {
            ImagesUploaded[0] = 1;
        }
        if(ArrayPhotoRef.Imagem2DaFoto != "none")
        {
            ImagesUploaded[1] = 1;
        }
        if(ArrayPhotoRef.Imagem3DaFoto != "none")
        {
            ImagesUploaded[2] = 1;
        }
        if(ArrayPhotoRef.Imagem4DaFoto != "none" && ProductTypeFromURL != "Tirinha 3 fotos")
        {
            ImagesUploaded[3] = 1;
        }
        // Verificando se alcançou o numero maximo de fotos
        CheckNumberOfPhotos(ArrayPhotoRef);
    }

    function RemoveAllPhotos(ArrayPhotoRef)
    {
        if(ArrayPhotoRef.Imagem1DaFoto != "none")
        {
            ArrayPhotoRef.Imagem1DaFoto = "none";
            RemovePhotoFromFolder();
        }
        if(ArrayPhotoRef.Imagem2DaFoto != "none")
        {
            ArrayPhotoRef.Imagem2DaFoto = "none";
            RemovePhotoFromFolder();
        }
        if(ArrayPhotoRef.Imagem3DaFoto != "none")
        {
            ArrayPhotoRef.Imagem3DaFoto = "none";
            RemovePhotoFromFolder();
        }
        if(ArrayPhotoRef.Imagem4DaFoto != "none" && ProductTypeFromURL != "Tirinha 3 fotos")
        {
            ArrayPhotoRef.Imagem4DaFoto = "none";
            RemovePhotoFromFolder();
        }
        localStorage.removeItem('PhotosInfo');
        var PhotosInfo = ArrayPhoto;
    }

    // Variavel que segura as fotos ja criadas
    if(localStorage.getItem('PhotosInfo') != null)
    {
        var PhotosInfo = JSON.parse(localStorage.getItem('PhotosInfo') || '{}');
        Imagem1DaFoto = PhotosInfo.Imagem1DaFoto;
        Imagem2DaFoto = PhotosInfo.Imagem2DaFoto;
        Imagem3DaFoto = PhotosInfo.Imagem3DaFoto;
        Imagem4DaFoto = PhotosInfo.Imagem4DaFoto;
    }
    else
        var PhotosInfo = ArrayPhoto;


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

    // Gerando preview das fotos criadas
    function UpdateCreatedPhotos(ArrayPhotoRef)
    {
        if(!ArrayPhotoRef)
            return;
        var i =0;
        if(PhotosInfo.Imagem1DaFoto != "none")
        {
            document.getElementById("previewimage1").src = PhotosInfo.Imagem1DaFoto;
            document.getElementById("previewimage1").style.display = "block";
        }
        if(PhotosInfo.Imagem2DaFoto != "none")
        {
            document.getElementById("previewimage2").src = PhotosInfo.Imagem2DaFoto;
            document.getElementById("previewimage2").style.display = "block";
        }
        if(PhotosInfo.Imagem3DaFoto != "none")
        {
            document.getElementById("previewimage3").src = PhotosInfo.Imagem3DaFoto;
            document.getElementById("previewimage3").style.display = "block";
        }
        if(ProductTypeFromURL != "Tirinha 3 fotos")
        {
            if(PhotosInfo.Imagem4DaFoto != "none")
            {
                document.getElementById("previewimage4").src = PhotosInfo.Imagem4DaFoto;
                document.getElementById("previewimage4").style.display = "block";
            }
        }
    }
</script>

<?php
// TODO: Precaucoes: https://www.php.net/manual/en/function.move-uploaded-file.php

    if (isset($_POST['ModeloPassed']))
    {
        if($_POST['ModeloPassed'] == "Tirinha 3 fotos")
            $Iteracoes = 3;
        else
            $Iteracoes = 4;

        for ($i = 0; $i<$Iteracoes;$i++)
        {
            // Pegando IdUnico
            $IdFile = fopen("UniqueID.txt", "r+") or die("Unable to open file!");
            $IdUnico = ((int)fgets($IdFile))+1;
            fclose($IdFile);
            // Update no arquivo
            $IdFile = fopen("UniqueID.txt", "w") or die("Unable to open file!");
            fwrite($IdFile, $IdUnico);
            fclose($IdFile);
            // Pegando qual foto vai ser upada
            if($i == 0)
                $PhotoToUploadRef = "PhotoToUpload1";
            else if($i == 1)
                $PhotoToUploadRef = "PhotoToUpload2";
            else if($i == 2)
                $PhotoToUploadRef = "PhotoToUpload3";
            else if($i == 3)
                $PhotoToUploadRef = "PhotoToUpload4";
            $NomeCliente = $_POST['ClientNamePassed']."_".$_POST['ModeloPassed']."_".$IdUnico.".png"; // file name
            if( move_uploaded_file($_FILES[$PhotoToUploadRef]["tmp_name"], "..\\SiteGiu\\JoinImages\\uploads\\".$NomeCliente) ) {
                echo 'File uploaded';
            } else {
                echo 'Something went wrong uploading file';
            }
        }
    }
?>

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

        .image-previewt1__image1 {
            display: none;
            position: absolute;
            width: 194px;
            height: 194px;
            top: 37px;
            left: 36px;
        }

        .image-previewt1__image2 {
            display: none;
            position: absolute;
            width: 194px;
            height: 194px;
            top: 257px;
            left: 36px;
        }

        .image-previewt1__image3 {
            display: none;
            position: absolute;
            width: 194px;
            height: 194px;
            top: 477px;
            left: 36px;
        }

        .image-previewt2__image1 {
            display: none;
            position: absolute;
            width: 160px;
            height: 160px;
            top: 25px;
            left: 40px;
        }

        .image-previewt2__image2 {
            display: none;
            position: absolute;
            width: 160px;
            height: 160px;
            top: 193px;
            left: 40px;
        }

        .image-previewt2__image3 {
            display: none;
            position: absolute;
            width: 160px;
            height: 160px;
            top: 358px;
            left: 41px;
        }

        .image-previewt2__image4 {
            display: none;
            position: absolute;
            width: 160px;
            height: 160px;
            top: 524px;
            left: 41px;
        }
    </style>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="site description" />
    <meta name="keywords" content="put here keyoword to find easy by google" />
</head>
<body style="background-image: url('Images/BackgroundImage.jpg')">
    <!-- Escolhendo modelos -->
    <div id="BaseDiv" style="display:flex;">

        <span style="margin-left: auto; margin-right: auto;text-align: center; vertical-align: top;">
            <img src="Images/Logo.png" alt="Our logo" style="width:400px;height:400px;" id="logo">

            <!-- Fazendo o upload da foto -->
            <form action="Montar-Tirinhas.php" method="post" id="AdicionarFotoForm" enctype="multipart/form-data">
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
                    function isNumberKey(evt)
                    {
                        var charCode = (evt.which) ? evt.which : evt.keyCode
                        if (charCode > 31 && (charCode < 48 || charCode > 57))
                            return false;
                        return true;
                    }
                </script>

                <p>Escolha sua foto: <input type="file" value="Escolha sua foto" name="PhotoToUpload1" id="PhotoToUpload1" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload2" id="PhotoToUpload2" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload3" id="PhotoToUpload3" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload4" id="PhotoToUpload4" style="display:none"></p>
                <input type="hidden" name="ModeloPassed" id="ModeloPassed" value="none">
                <p><input onclick="AdicionarFoto(PhotosInfo);" style="display:none" type="button" name="AddPhotoButton" id="AddPhotoButton" value="Finalizar Foto"></p>
            <script>
                if(localStorage.getItem('ClientName') != null)
                    document.getElementById('AddPhotoButton').style.display = "inline-block";
            </script>
            </form>
            <p><input onclick="RemoveAllPhotos(PhotosInfo);" type="button" name="RemovePhotosButton" id="RemovePhotosButton" value="Remover Fotos"></p>
        </span>

        <span style="margin-left: auto; margin-right: auto;text-align: center; vertical-align: top;">

            <!-- Preview da foto atual -->
            <p>Como sua foto vai ficar: </p>
            <div class="base-image">
                <img src="" id='basepreview' width="264" height="711" class="base-image"/>
                <img src="" alt="Faça o upload para ver como sua foto vai ficar" class="image-previewt1__image1" id="previewimage1">
                <img src="" alt="Faça o upload para ver como sua foto vai ficar" class="image-previewt1__image2" id="previewimage2">
                <img src="" alt="Faça o upload para ver como sua foto vai ficar" class="image-previewt1__image3" id="previewimage3">
                <img src="" alt="Faça o upload para ver como sua foto vai ficar" class="image-previewt2__image4" id="previewimage4">
            </div>
            <p>*resultado aproximado*</p>
            <!-- Verificando classe das fotos -->
            <script>
                if(ProductTypeFromURL != "Tirinha 3 fotos")
                {
                    document.getElementById('previewimage1').className = "image-previewt2__image1";
                    document.getElementById('previewimage2').className = "image-previewt2__image2";
                    document.getElementById('previewimage3').className = "image-previewt2__image3";
                    document.getElementById('previewimage4').className = "image-previewt2__image4";
                }
            </script>
            
            <!-- Preview das fotos feitas -->
            <script>
                // Check se ha foto para ser adicionada ao preview
                if(localStorage.getItem('PhotosInfo') != null)
                {
                    UpdateCreatedPhotos(PhotosInfo);
                }
                else
                    document.getElementById("PhotoToUpload1").style.display = "block";
                    
                // Setup image preview
                const PhotoImage1 = document.getElementById('previewimage1');
                const PhotoImage2 = document.getElementById('previewimage2');
                const PhotoImage3 = document.getElementById('previewimage3');
                const PhotoImage4 = document.getElementById('previewimage4');
                var i;
                for(i=0;i<4;i++)
                {
                    if(i==0)
                        PhotoToUploadRef = "PhotoToUpload1";
                    else if(i==1)
                        PhotoToUploadRef = "PhotoToUpload2";
                    else if(i==2)
                        PhotoToUploadRef = "PhotoToUpload3";
                    else if(i==3)
                        PhotoToUploadRef = "PhotoToUpload4";
                    const PhotoFile = document.getElementById(PhotoToUploadRef);
                    PhotoFile.addEventListener("change", function() 
                    { 
                        const file = this.files[0];
                        if(file)
                        {
                            const reader = new FileReader();

                            reader.addEventListener("load" , function()
                            {
                                if(PhotoImage1.style.display != "block")
                                {
                                    Imagem1DaFoto = this.result;
                                    PhotoImage1.setAttribute("src", this.result);
                                    PhotoImage1.style.display = "block";
                                    document.getElementById("PhotoToUpload1").style.display = "none";
                                    document.getElementById("PhotoToUpload2").style.display = "block";
                                    PhotosInfo.Imagem1DaFoto = this.result;
                                }
                                else if(PhotoImage2.style.display != "block")
                                {
                                    Imagem2DaFoto = this.result;
                                    PhotoImage2.setAttribute("src", this.result);
                                    PhotoImage2.style.display = "block";
                                    document.getElementById("PhotoToUpload2").style.display = "none";
                                    document.getElementById("PhotoToUpload3").style.display = "block";
                                    PhotosInfo.Imagem2DaFoto = this.result;
                                }
                                else if(PhotoImage3.style.display != "block")
                                {
                                    Imagem3DaFoto = this.result;
                                    PhotoImage3.setAttribute("src", this.result);
                                    PhotoImage3.style.display = "block";
                                    document.getElementById("PhotoToUpload3").style.display = "none";
                                    if(ProductTypeFromURL == "Tirinha 3 fotos")
                                    {
                                        document.getElementById("FinalizarPedidoButton").style.display = "block";
                                    }
                                    else
                                        document.getElementById("PhotoToUpload4").style.display = "block";
                                    PhotosInfo.Imagem3DaFoto = this.result;
                                }
                                else if(PhotoImage4.style.display != "block" && ProductTypeFromURL != "Tirinha 3 fotos")
                                {
                                    Imagem4DaFoto = this.result;
                                    PhotoImage4.setAttribute("src", this.result);
                                    PhotoImage4.style.display = "block";
                                    PhotosInfo.Imagem4DaFoto = this.result;
                                }
                            });

                            reader.readAsDataURL(file);
                        }
                    });
                }
            </script>
            <!-- Definindo preview image -->
            <script>
                processUser();
                if (ProductTypeFromURL == "Tirinha 3 fotos")
                    document.getElementById("basepreview").src = "Images/Modelos/ModeloTirinha3Preview.png";
                else
                {
                    document.getElementById("basepreview").style.width = 238;
                    document.getElementById("basepreview").src = "Images/Modelos/ModeloTirinha4Preview.png";
                }
            </script>

        </span>

    </div>
</body>
</html>
