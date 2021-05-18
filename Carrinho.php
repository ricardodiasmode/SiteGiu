<script>

    var ProductNameFromURL = "";
    var ProductType1 = "none";
    var ProductType2 = "none";
    var PhotosInfo = "none";

    function processUser()
    {
        var urlRef = new URL(window.location.href);
        ProductNameFromURL = urlRef.searchParams.get("ProductNameRef");
        ProductType1 = urlRef.searchParams.get("ProductType1Ref");
        ProductType2 = urlRef.searchParams.get("ProductType2Ref");
    }

    /*
    =====> Checking browser support.
    //This step might not be required because most modern browsers do support HTML5.
    */
    //Function below might be redundant.
    function CheckBrowser() {
        if ('localStorage' in window && window['localStorage'] !== null) {
            // We can use localStorage object to store data.
            return true;
        } else {
                return false;
        }
    }

    function SaveItem()
    {
        if(ProductNameFromURL != null)
        {
            var CurrentAmount = 1;
            if(ProductType2 == 'none')
            {
                var ItemJSON = JSON.parse(localStorage.getItem(ProductNameFromURL) || '{}');
                if(localStorage.getItem(ProductNameFromURL) != null)
                {
                    CurrentAmount = ItemJSON.Quantidade+1;
                }
            }
            var ProductInfoArray = {Quantidade: CurrentAmount, Tipo1: ProductType1, Tipo2: ProductType2};
            localStorage.setItem(ProductNameFromURL, JSON.stringify(ProductInfoArray));
        }
        doShowAll();
    }

    //Change an existing key-value in HTML5 storage.
    function ModifyItem() 
    {
        var name1 = document.forms.ShoppingList.name.value;
        var data1 = document.forms.ShoppingList.data.value;
        //check if name1 is already exists

        //Check if key exists.
        if (localStorage.getItem(name1) !=null)
        {
            //update
            localStorage.setItem(name1,data1);
            document.forms.ShoppingList.data.value = localStorage.getItem(name1);
        }

        doShowAll();
    }

    function RemoveItem(ItemName)
    {
        document.forms.ShoppingList.data.value=localStorage.removeItem(ItemName);
        doShowAll();
    }

    function ClearAll() 
    {
        localStorage.clear();
        doShowAll();
    }

    invoke = (event) => {
        let ItemNameRef = event.target.getAttribute('name');
        RemoveItem(ItemNameRef);
    }

    // Dynamically populate the table with shopping list items.
    function doShowAll() {
        if (CheckBrowser()) {
            // Criando a lista
            var table = document.getElementById('list');
            table.innerHTML = "";
            var key = "";
            // Headers
            var ItemHeader = table.createTHead();
            var ItemRow = ItemHeader.insertRow(0);
            var ItemCell = ItemRow.insertCell(0);
            var QuantidadeCell = ItemRow.insertCell(0);
            if(ProductType1 != 'none')
            {
                var Tipo1Cell = ItemRow.insertCell(2);
                Tipo1Cell.innerHTML = "<b>Tipo</b>";
            }
            if(ProductType2 != 'none')
            {
                var Tipo2Cell = ItemRow.insertCell(3);
                Tipo2Cell.innerHTML = "<b>Extras</b>";
            }
            ItemCell.innerHTML = "<b>Quantidade</b>";
            QuantidadeCell.innerHTML = "<b>Item</b>";
            
            // Produtos
            var i = 0;
            for (i = 0; i < localStorage.length; i++) {
                key = localStorage.key(i); 
                if(key == 'PhotosInfo' || key == 'ClientName')
                    continue;
                // key = localStorage.key(i) => Product name
                var StorageValues = JSON.parse(localStorage.getItem(key) || '{}');
                // StorageValues.Quantidade => Product amount
                // StorageValues.Tipo1 => Product type 1
                // StorageValues.Tipo2 => Product type 2
                // Criando tabela
                var CurrentItemRow = ItemHeader.insertRow(i+1);
                var CurrentItemCell = CurrentItemRow.insertCell(0);
                var CurrentQuantidadeCell = CurrentItemRow.insertCell(1);
                CurrentItemCell.innerHTML = "<b>"+ key +"</b>";
                CurrentQuantidadeCell.innerHTML = "<b>"+ StorageValues.Quantidade +"</b>";
                // Definindo tipos
                if(localStorage.getItem(key)[1] != 'none')
                {
                    var CurrentTipo1Cell = CurrentItemRow.insertCell(2);
                    CurrentTipo1Cell.innerHTML = "<b>"+ StorageValues.Tipo1 +"</b>";
                }
                else
                {
                    CurrentItemRow.insertCell(2);
                }
                if(localStorage.getItem(key)[2] != 'none')
                {
                    var CurrentTipo2Cell = CurrentItemRow.insertCell(3);
                    CurrentTipo2Cell.innerHTML = "<b>"+ StorageValues.Tipo2 +"</b>";
                }
                else
                {
                    CurrentItemRow.insertCell(2);
                }
                // Criando botao
                var BotaoRemoverCell = CurrentItemRow.insertCell(4);
                var BotaoRemoverProduto = document.createElement('input');
                BotaoRemoverProduto.type = "button";
                BotaoRemoverProduto.value = "Remover Produto";
                BotaoRemoverProduto.name = key;
                BotaoRemoverProduto.onclick = invoke;
                BotaoRemoverCell.appendChild(BotaoRemoverProduto);
            }
        } else {
            alert('Cannot save shopping list as your browser does not support HTML 5');
        }
    }

    function CompletarPedido()
    {
        document.getElementById('Nome').value = localStorage.getItem('ClientName');
        localStorage.setItem('FezPedido', 'true');
        document.getElementById('EmailForm').submit();
    }



    function CheckDadosPreenchidos()
    {
        NomeDoCliente = document.getElementById('Nome');
        ContatoCliente = document.getElementById('Contato');
        CidadeCliente = document.getElementById('Cidade');
        BairroCliente = document.getElementById('Bairro');
        RuaCliente = document.getElementById('Rua');
        Numero = document.getElementById('Numero');
        if(NomeDoCliente.value != ""
        && ContatoCliente.value != ""
        && CidadeCliente.value != ""
        && BairroCliente.value != ""
        && RuaCliente.value != ""
        && Numero.value != "")
        {
            document.getElementById('BotaoCompletarPedido').style.display = "block";
        }
    }

</script>

<!doctype html>
<html lang="pt-BR">
<head>
    <title>Memories - Meu Carrinho</title>
    <meta charset="utf-8" />
    <meta name="description" content="site description" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="put here keyoword to find easy by google" />
    <meta name="author" content="Ricardo Avelar, Giulia Aurelio">
    <!-- Default content -->
    <style>

        .header
        {
            margin: 0px;
            padding: 0px;
            height: 45px;
            overflow: hidden;
            text-align: center;
            background: #FAACB7;
            color: white;
            font-size: 20px;
        }
        body
        {
            margin: 0px;
            padding: 0px;
        }
        @font-face { font-family: rage-italic; src: url('rage-italic.TTF'); } 
        h1 {
            font-family: rage-italic;
        }
        h2 {
            font-family: Arial;
            color: #878787;
            text-align: center;
            font-weight: normal;
        }
        h3 {
            font-family: Arial;
            text-align: center;
            font-size: 20px;
            margin-top: 10px;
            color: #CB997E;
        }
        h4 {
            text-align: center;
            font-size: 18px;
            color: #FAACB7;
            font-weight: normal;
        }
        .LetrasHeader
        {
            font-family: Arial;
            font-size: 18px;
            text-align: right;
            margin-right: 200px;
            margin-top: 15px;
            font-weight: bold;
        }
        .footer
        {
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100px;
            background-color: #FFF7F6;
            color: white;
            text-align: center;
            margin-top: 100px;
        }
        a {
            color:white;
            text-decoration: none ;
        }

        a:hover {
            color:white;
            text-decoration:none;
            cursor:pointer;
        }

        .InformacoesDiv
        {
            text-align: center;
            padding-top: 20px;
        }

        /* Table style */
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
        margin: auto;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }

        .Logo {
            display: block;
            width: 300px;
            height: 300px;
            margin: auto;
        }

    </style>
    <div class="header">
        <p class = "LetrasHeader"><a href="Carrinho.php">Meu carrinho</a></p>
    </div>
</head>
<body style="background-color:rgb(255, 255, 255)" onload="doShowAll()">
    <div id="BaseDiv">
        <!-- Logo -->
        <p style="text-align: center; display: block">
        <h2 id="MensagemParaCliente" style="display: block;margin: auto;"></h2>
        <img alt="memories logo" src="Images/Logo.png" class="Logo" id="SiteLogo">
        </p>
        <!-- Carrinho -->
        <form name="ShoppingList">
            <div id="items_table" style="text-align: center;">
                <h2>Meus Produtos</h2>
                <table id="list"></table>
                <p><input type="button" value="Remover Todos Os Produtos" onclick="ClearAll()"></p>
            </div>
        </form>   
        <!-- Informações pessoais -->
        <div class="InformacoesDiv">
            <form action="SendMail.php" method="post" enctype="multipart/form-data" id="EmailForm">
                <h3>Informações pessoais</h3>
                <label for="Nome">Seu nome e sobrenome*:</label><br>
                <input onchange="CheckDadosPreenchidos()" type="text" id="Nome" name="Nome"><br><br>
                <label for="Nome">E-mail ou numero de telefone para contato*:</label><br>
                <input onchange="CheckDadosPreenchidos()" type="text" id="Contato" name="Contato"><br><br>
                <h4>Endereço para entrega</h4>
                <label for="Estado">Estado*:</label><br>
                <input onchange="CheckDadosPreenchidos()" type="text" id="Estado" name="Estado"><br><br>
                <label for="Cidade">Cidade*:</label><br>
                <input onchange="CheckDadosPreenchidos()" type="text" id="Cidade" name="Cidade"><br><br>
                <label for="Bairro">Bairro*:</label><br>
                <input onchange="CheckDadosPreenchidos()" type="text" id="Bairro" name="Bairro"><br><br>
                <label for="Rua">Rua*:</label><br>
                <input onchange="CheckDadosPreenchidos()" type="text" id="Rua" name="Rua"><br><br>
                <label for="Número">Número*:</label><br>
                <input onchange="CheckDadosPreenchidos()" type="text" id="Numero" name="Numero"><br><br>
                <label for="Complemento">Complemento:</label><br>
                <input type="text" id="Complemento" name="Complemento"><br><br>
                <label for="Referencia">Referência:</label><br>
                <input type="text" id="Referencia" name="Referencia"><br><br>
                <h4>Recado para nós</h4>
                <label for="Recado">Qualquer coisa que queira nos dizer:</label><br>
                <input type="text" id="Recado" name="Recado"><br><br>
                <input type="button" onclick="CompletarPedido()" value="Completar pedido" style="width: 150px; display:none; margin: auto" id="BotaoCompletarPedido">
              </form>
        </div>
    </div>
    <div class="footer">
        <p>Footer</p>
    </div>
    
    <script>
        // Setting new product on cart
        if(localStorage.getItem('PhotosInfo') != null)
            PhotosInfo = JSON.parse(localStorage.getItem('PhotosInfo') || '{}');
        processUser();
        SaveItem();
        
        // Setting message or logo
        if(ProductNameFromURL == "Box Memories"
        || ProductNameFromURL == "Polaroid Branca"
        || ProductNameFromURL == "Tirinhas 3/4 Fotos")
        {
            document.getElementById("MensagemParaCliente").innerHTML = "Parabéns " + 
            localStorage.getItem('ClientName') +
            "! Suas fotos montadas foram enviadas para nós, agora você pode voltar para nosso catálogo ou preencher o formulário abaixo e finalizar a compra:";
            document.getElementById('SiteLogo').remove();
        }
        else
        {
            document.getElementById('MensagemParaCliente').remove();
        }
    </script>
</body>
</html>
