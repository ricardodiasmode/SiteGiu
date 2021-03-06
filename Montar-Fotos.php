<script type="text/javascript">

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

    function SetPreviewImage(srcToSet)
    {
        ImagemDaFoto = srcToSet;
    }

    function SetupLegendaPreview()
    {
        if(document.getElementById('legendacb').checked === true)
            document.getElementById('previewlegenda').style.display = "inline-block";
        else
            document.getElementById('previewlegenda').style.display = "none";
        if(Modelo === "m1")
            document.getElementById('previewlegenda').style.bottom = "15px";
        else
            document.getElementById('previewlegenda').style.bottom = "-130px";
        var LegendaWidth = document.getElementById('previewlegenda').getBoundingClientRect().width;
        document.getElementById('previewlegenda').style.left = -LegendaWidth/2;
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

</script>

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
    var PhotosInfo = [];
    var i;
    var MaxNumberOfPhotos = 10;

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

    function CheckNumberOfPhotos(QuerFinalizar)
    {
        document.getElementById('ClientNamePassed').value = localStorage.getItem("ClientName");
        if(QuerFinalizar != true)
            PhotosInfo.push({Modelo: Modelo, ComMusica: ComMusica, MusicaDoYt: MusicaDoYt, ComLegenda: ComLegenda, LegendaDaFoto: LegendaDaFoto, LinkMusicaEscolhida: LinkMusicaEscolhida});
        document.getElementById('CaracteristicasPhotos').value = JSON.stringify(PhotosInfo);
        if(parseInt(NumeroFotosMontadas+1) >= MaxNumberOfPhotos)
        {
            if(document.getElementById('TextoInstrucao').innerText == "5. Mais Fotos?")
            {
                if(QuerFinalizar == true)
                   IrParaCarrinho = 'true';
                document.getElementById('AdicionarFotoForm').action = "Montar-Fotos.php?ProductNameRef="+ProductNameFromURL+"&ProductType1Ref="+ProductTypeFromURL+"&ProductType2Ref="+ProductType2FromURL+"&IrParaCarrinho="+IrParaCarrinho+"&NumeroFotosMontadas="+NumeroFotosMontadas;
                document.getElementById('AdicionarFotoForm').submit();
            }
            else
            {
                document.getElementById('TextoInstrucao').innerText = "5. Mais Fotos?";
                document.getElementById('FinalizarPedidoButton').style.display = "inline-block";
            }
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
                document.getElementById('NumeroFotosMontadas').value = NumeroFotosMontadas;
            }
            document.getElementById('TextoInstrucao').innerText = "5. Agora faca pelo menos mais "+(10-NumeroFotosMontadas).toString()+" fotos";
            document.getElementById('SpanExtrasDaFoto').style.display = "none";
        }
    }

    function SetModelo(id) {
        Modelo = id;
        SetModeloPreview();
    }

    function SetModeloPreview()
    {
        if(Modelo === 'm1')
        {
            document.getElementById('basepreview').src = "Images/Modelos/Modelo1Separado.png";
            document.getElementById('basepreview').width = "449";
            document.getElementById('basepreview').height = "507.5";
            document.getElementById('PreviewCurrentImage').width = "372";
            document.getElementById('PreviewCurrentImage').height = "372";
            document.getElementById('PreviewCurrentImage').style.top = "332px";
            document.getElementById('PreviewCurrentImage').style.left = "463px";
        }
        else
        {
            document.getElementById('basepreview').src = "Images/Modelos/Modelo2Separado.png";
            document.getElementById('basepreview').width = "449";
            document.getElementById('basepreview').height = "681.7";
            document.getElementById('PreviewCurrentImage').width = "358";
            document.getElementById('PreviewCurrentImage').height = "480";
            document.getElementById('PreviewCurrentImage').style.top = "339px";
            document.getElementById('PreviewCurrentImage').style.left = "470px";
        }
        // Sumindo com o botao para selecionar modelo
        document.getElementById('Molde1Button').style.display = "none";
        document.getElementById('Molde2Button').style.display = "none";
        document.getElementById('DivPreviewFotoAtual').style.display = "block";
        document.getElementById('ContinuarButton').style.display = "none";
        document.getElementById('EscolhaFotoText').style.display = "inline-block";
        // Deixando botao de upar foto visivel
        var IdPhotoToUpload;
        if(NumeroFotosMontadas != null)
            IdPhotoToUpload = "PhotoToUpload"+(parseInt(NumeroFotosMontadas)+1).toString();
        else
            IdPhotoToUpload = "PhotoToUpload"+(1).toString();
        document.getElementById(IdPhotoToUpload).style.display = "inline-block";
        document.getElementById('TextoInstrucao').innerText = "3. Escolha sua Foto";
    }

    function ContinuarProximaEtapa()
    {
        // Verificar se ja colocou o nome
        if(localStorage.getItem('ClientName') != null)
        {
            // Removendo da tela o cb de colocar nome
            document.getElementById('NomeClienteParagrafo').style.display = "none";
            document.getElementById('ClientNamePassed').style.display = "none";
            // Deixando Visivel modelos para escolha
            document.getElementById('TextoInstrucao').innerText = "2. Escolha seu Molde";
            if(document.getElementById('Molde1Button').style.display == "none")
            {
                if(document.getElementById('EscolhaFotoText').style.display == "inline-block")
                {
                    for(i=1;i<11;i++)
                    {
                        var IdPhotoToUpload;
                        IdPhotoToUpload = "PhotoToUpload"+(i).toString();
                        document.getElementById(IdPhotoToUpload).style.display = "none";
                    }
                    document.getElementById('TextoInstrucao').innerText = "4. Escolha os Adicionais";
                    document.getElementById('EscolhaFotoText').style.display = "none";
                    document.getElementById('SpanExtrasDaFoto').style.display = "inline-block";
                }
                else
                {
                    if(document.getElementById('SpanExtrasDaFoto').style.display == "inline-block")
                    {
                        CheckNumberOfPhotos(false);
                    }
                    else
                    {
                        document.getElementById('DivPreviewFotoAtual').style.display = "none";
                        document.getElementById('PreviewCurrentImage').style.display = "none";
                        document.getElementById('Molde1Button').style.display = "inline-block";
                        document.getElementById('Molde2Button').style.display = "inline-block";
                        document.getElementById("ContinuarButton").style.display = "none";
                    }
                }
            }
        }
    }
</script>

<?php
// TODO: Precaucoes: https://www.php.net/manual/en/function.move-uploaded-file.php

    if (isset($_POST['CaracteristicasPhotos']))
    {
        $CaracteristicasArray = json_decode($_POST['CaracteristicasPhotos'], true);
        $pathToLinkMusicas = "D:\\xampp\\htdocs\\SiteGiu\\JoinImages\\uploads\\LinkMusicas.txt";
        $LinkMusicasFile = fopen($pathToLinkMusicas, "a");
        for($i=0;$i<count($CaracteristicasArray);$i++)
        {
            // Pegando IdUnico
            $IdFile = fopen("UniqueID.txt", "r+") or die("Unable to open file!");
            $IdUnico = ((int)fgets($IdFile))+1;
            fclose($IdFile);
            // Update no arquivo
            $IdFile = fopen("UniqueID.txt", "w") or die("Unable to open file!");
            fwrite($IdFile, $IdUnico);
            fclose($IdFile);
            $CaracteristicasRef = $CaracteristicasArray[$i];
            $NomeCliente = $_POST['ClientNamePassed']."_".$CaracteristicasRef["Modelo"]."_".$CaracteristicasRef["ComMusica"]."_".$CaracteristicasRef["MusicaDoYt"]."_".$CaracteristicasRef["ComLegenda"]."_"."Legenda="."_".$CaracteristicasRef["LegendaDaFoto"]."_".$IdUnico.".png"; // file name
            $PhotoToUploadCurrentId = "PhotoToUpload".strval($i+1);
            // Verificando tipo do arquivo
            $OldFileName = $_FILES[$PhotoToUploadCurrentId]['name'];
            $FileName = $_FILES[$PhotoToUploadCurrentId]['tmp_name'];
            if (isset(pathinfo($OldFileName)['extension']))
            {
                if(pathinfo($OldFileName)['extension'] == 'jpg' ||
                pathinfo($OldFileName)['extension'] == 'jpeg' ||
                pathinfo($OldFileName)['extension'] == 'jpe' ||
                pathinfo($OldFileName)['extension'] == 'png')
                {
                    // Verificando se o nome do arquivo eh <= 225
                    if((mb_strlen($FileName,"UTF-8") <= 225))
                    {
                        if( move_uploaded_file($FileName, "..\\SiteGiu\\JoinImages\\uploads\\".$NomeCliente) ) {
                            echo 'File uploaded';
                        } else {
                            echo 'Something went wrong uploading file / FileName: '.$FileName.' / ClientName: '.$NomeCliente;
                        }
                    }
                }
            }
            else
            {
                // Verificando se o nome do arquivo eh <= 225
                if((mb_strlen($FileName,"UTF-8") <= 225))
                {
                    if( move_uploaded_file($FileName, "..\\SiteGiu\\JoinImages\\uploads\\".$NomeCliente) ) {
                        echo 'File uploaded';
                    } else {
                        echo 'Something went wrong uploading file / FileName: '.$FileName.' / ClientName: '.$NomeCliente;
                    }
                }
            }
            // Criando .txt com id e link da musica
            if (isset($CaracteristicasRef["LinkMusicaEscolhida"]))
                $txt = $IdUnico.":".$CaracteristicasRef["LinkMusicaEscolhida"]."\n";
            else
                $txt = $IdUnico.":"."none"."\n";
            fwrite($LinkMusicasFile, $txt);
        }
        fclose($LinkMusicasFile);
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
        .PreviewCurrentImage {
            display: none;
            position: absolute;
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

        .LegendaPhotoAddedPreview
        {
            display: block;
            position: absolute;
        }
    </style>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="site description" />
    <meta name="keywords" content="put here keyoword to find easy by google" />
</head>
<body style="background-image: url('Images/BackgroundImage.jpg')">
    <!-- Escolhendo modelos -->
    <div id="BaseDiv" style="display:block;width:100%;margin-top:50px">

        <span style="text-align: left; vertical-align: top;">
            <input onclick="SetModelo('m1')" type="image" src="Images/Modelos/Modelo1Separado.png" alt="Modelo1Img" style="display:none;position:absolute;width:449px;height:507.5px;left:0;top:0px" id="Molde1Button" />
        </span>

        <span style="text-align: center; vertical-align:top;">
            <h1 id='TextoInstrucao'>1. Escreva seu Nome</h1>
            <span id='SpanExtrasDaFoto' style="display:none;margin-top:-20px;">
                <!-- Escolhendo se tem musica ou nao -->
                <input onclick="ToggleCheckBox('musicacb')" type="checkbox" id="musicacb" name="musicacb">
                <label for="musicacb">Com Musica?</label>

                <!-- Escolhendo se a musica vem do youtube -->
                <p><input onclick="ToggleCheckBox('ytcb')" style="display:none" type="checkbox" id="ytcb" name="ytcb" checked>
                <label style="display:none" id="ytlb" for="ytcb">Do youtube?</label>
                <!-- Escolhendo se a musica vem do spotify -->
                <input onclick="ToggleCheckBox('spotifycb')" style="display:none" type="checkbox" id="spotifycb" name="spotifycb">
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
                <p style="margin-bottom:0px;"><input onclick="ToggleIma()" type="checkbox" id="imacb" name="imacb">
                <label for="imacb">Com Imã?</label></p>
            </span>

            <!-- Fazendo o upload da foto -->
            <form action="Montar-Fotos.php" method="post" id="AdicionarFotoForm" enctype="multipart/form-data">
                <p id="NomeClienteParagrafo"><label for="ClientNamePassed" id="ClientNamePassedlabel">Seu Nome*: </label></p>
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
                            document.getElementById("ContinuarButton").style.display = "none";
                            return;
                        }
                        if(localStorage.getItem('ClientName') == null)
                            ClientNameRef = ClientNameRef + uuidv4();
                        else
                            ClientNameRef = localStorage.getItem('ClientName');
                        localStorage.setItem("ClientName", ClientNameRef);
                        document.getElementById("ContinuarButton").style.display = "inline-block";
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
                <p><span id="EscolhaFotoText" style="display:none">Escolha sua foto:</span> <input type="file" value="Escolha sua foto" name="PhotoToUpload1" id="PhotoToUpload1" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload2" id="PhotoToUpload2" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload3" id="PhotoToUpload3" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload4" id="PhotoToUpload4" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload5" id="PhotoToUpload5" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload6" id="PhotoToUpload6" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload7" id="PhotoToUpload7" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload8" id="PhotoToUpload8" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload9" id="PhotoToUpload9" style="display:none">
                <input type="file" value="Escolha sua foto" name="PhotoToUpload10" id="PhotoToUpload10" style="display:none"></p>
                <input type="hidden" value="" name="NumeroFotosMontadas" id="NumeroFotosMontadas">
                <input type="hidden" name="CaracteristicasPhotos" id="CaracteristicasPhotos" value="none">
            </form>

            <!-- Preview da foto atual -->
            <p style="text-align: center;">
                <input onclick="CheckNumberOfPhotos(true)" style="display:none" type="button" name="FinalizarPedidoButton" id="FinalizarPedidoButton" value="Finalizar Pedido">
                <input onclick="ContinuarProximaEtapa(false)" style="display:none" type="button" name="ContinuarButton" id="ContinuarButton" value="Continuar">
            </p>
            <div id="DivPreviewFotoAtual" style="display: none;text-align: center;">
            <p>Como sua foto vai ficar:</p>
            <p>
                <p style="position:absolute;left:50%;top:280px"><img src="" id='basepreview' style="position:relative;left:-50%;" /></p>
                <img src="" alt="Faça o upload para ver como sua foto vai ficar" class="PreviewCurrentImage" id="PreviewCurrentImage">
            </p>
            <p>*resultado aproximado*</p>
            </div>
            <span style="position:absolute;top:715px">
            <h1 id="previewlegenda" style="position:relative;display:none;left:0px;">SuaLegenda</h1>
            </span>
            
            <!-- Preview das fotos feitas -->
            <p><div id="photos-content" style="display:flex;height: 200px;">
            </div></p>
            
            <!-- Definindo preview image -->
            <script>
                processUser();
                // Setup image preview
                const PhotoImage = document.getElementById('PreviewCurrentImage');
                var i;
                for (i=1;i<11;i++)
                {
                    var PhotoToUploadElementId;
                    PhotoToUploadElementId = "PhotoToUpload"+i.toString();
                    const PhotoFile = document.getElementById(PhotoToUploadElementId);

                    PhotoFile.addEventListener("change", function() 
                    {
                        document.getElementById('ContinuarButton').style.display = "inline-block";
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
                            document.getElementById('ContinuarButton').style.display = "none";
                            PhotoImage.style.display = "none";
                            SetPreviewImage('');
                        }
                    });
                }
            </script>
        </span>

        <span style="text-align: right; vertical-align: top;">
            <input onclick="SetModelo('m2')" type="image" src="Images/Modelos/Modelo2Separado.png" alt="Modelo2Img" style="display:none;position:absolute;width:393.6px;height:597.6px;right:0px;top:0px" id="Molde2Button" />
        </span>
        <script>ContinuarProximaEtapa();</script>
    </div>
</body>
</html>
