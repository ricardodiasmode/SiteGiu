<script type="text/javascript" src="Montar-Fotos.js"></script>

<?php
// TODO: Precaucoes: https://www.php.net/manual/en/function.move-uploaded-file.php
    if (isset($_POST['ModeloPassed']))
    {
        $NomeCliente = $_POST['ClientNamePassed']."_".$_POST['ModeloPassed']."_".$_POST['ComMusicaPassed']."_".$_POST['MusicaYtPassed']."_".$_POST['ComLegendaPassed']."_".$_POST['LinkMusicaPassed']."_"."Legenda="."_".$_POST['LegendaPassed'].".png"; // file name
        if( move_uploaded_file($_FILES["PhotoToUpload"]["tmp_name"], "..\\SiteGiu\\uploads\\".$NomeCliente) ) {
            echo 'File uploaded';
        } else {
            echo 'Something went wrong uploading file';
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
            width: 149px;
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
                    // Set client name
                    SetNomeCliente = (event) => {
                        let ClientNameRef = event.target.getAttribute('value');
                        localStorage.setItem("ClientName", ClientNameRef);
                        document.getElementById("AddPhotoButton").style.display = "inline-block";
                    }
                    // Criando text box onde o cliente vai colocar o nome dele
                    var ClientNameTB = document.createElement("input");
                    ClientNameTB.type = "text";
                    ClientNameTB.id = "ClientNamePassed";
                    ClientNameTB.name = "ClientNamePassed";
                    ClientNameTB.onchange = SetNomeCliente;
                    document.getElementById("NomeClienteParagrafo").appendChild(ClientNameTB);
                </script>
                <p>Escolha sua foto: <input type="file" value="Escolha sua foto" name="PhotoToUpload" id="PhotoToUpload"></p>
                <input type="hidden" name="ModeloPassed" id="ModeloPassed" value="">
                <input type="hidden" name="ComMusicaPassed" id="ComMusicaPassed" value="">
                <input type="hidden" name="MusicaYtPassed" id="MusicaYtPassed" value="">
                <input type="hidden" name="ComLegendaPassed" id="ComLegendaPassed" value="">
                <input type="hidden" name="LinkMusicaPassed" id="LinkMusicaPassed" value="">
                <input type="hidden" name="LegendaPassed" id="LegendaPassed" value="">
                <p><input onclick="GetDataFormValues();AdicionarFoto();" style="display:none" type="submit" name="AddPhotoButton" id="AddPhotoButton" value="Adicionar Foto"></p>
            </form>
            
            <!-- Preview das fotos feitas -->
            <p><div id="photos-content" style="display:flex;height: 200px;">
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
