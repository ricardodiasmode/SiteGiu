<script>
    var ProductImageFromURL = "a";
    var ProductNameFromURL = "b";
    var ProductPriceFromURL = "c";
    var ProductDescriptionFromURL = "d";
    
    let ProductTypeArray = [
        { ProductTypeFromURL: "none", },
        { ProductTypeFromURL: "none", },
        { ProductTypeFromURL: "none", },
        { ProductTypeFromURL: "none", },
        { ProductTypeFromURL: "none", },
        { ProductTypeFromURL: "none", },
    ];
    
    let ProductTypeSelected = [
        { Tipo: "none" },
        { Tipo: "none" },
    ];

    // Creating arrays of images
    let BoxMemoriesImageArray = [
        { ImageSrc: "Images/Catalogo/BoxMemories.jpeg" },
    ];
    let ScrapBookImageArray = [
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBookCapa.jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/3ScrapBookBege.jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/3ScrapBookPreto.jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (1).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (2).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (3).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (4).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (5).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (6).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (7).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (8).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (9).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (10).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (11).jpeg" },
        { ImageSrc: "Images/Catalogo/ScrapBook/ScrapBook (12).jpeg" },
    ];

    function processUser()
    {
        var urlRef = new URL(window.location.href);
        ProductImageFromURL = urlRef.searchParams.get("ProductImage");
        ProductNameFromURL = urlRef.searchParams.get("ProductName");
        ProductPriceFromURL = urlRef.searchParams.get("ProductPrice");
        ProductDescriptionFromURL = urlRef.searchParams.get("ProductDescription");
    
        ProductTypeArray[0].ProductTypeFromURL = urlRef.searchParams.get("ProductType1");
        ProductTypeArray[1].ProductTypeFromURL = urlRef.searchParams.get("ProductType2");
        ProductTypeArray[2].ProductTypeFromURL = urlRef.searchParams.get("ProductType3");
        ProductTypeArray[3].ProductTypeFromURL = urlRef.searchParams.get("ProductType4");
        ProductTypeArray[4].ProductTypeFromURL = urlRef.searchParams.get("ProductType5");
        ProductTypeArray[5].ProductTypeFromURL = urlRef.searchParams.get("ProductType6");
    }

    function GetImagesArrayByName(ProductName)
    {
        if(ProductName === 'Box Memories')
            return BoxMemoriesImageArray;
        if(ProductName === 'ScrapBook')
            return ScrapBookImageArray;
        return null;
    }

    function SetProductImage()
    {
        processUser();
        var ProductImageRef = document.createElement("img");
        ProductImageRef.className = "ProductImageClass";
        ProductImageRef.src = ProductImageFromURL;
        ProductImageRef.id = "ProductImage";
        document.getElementById('ProductInfoDiv').appendChild(ProductImageRef);
    }

    function SetProductImageByIndex(IndexRef)
    {
        var ImagesArray = GetImagesArrayByName(ProductNameFromURL);
        console.log(IndexRef);
        document.getElementById('ProductImage').src = ImagesArray[IndexRef].ImageSrc;
    }

    invoke = (event) => {
        let SrcRef = event.target.getAttribute('src');
        document.getElementById('ProductImage').src = SrcRef;
    }

    function GetSecondaryImages()
    {
        var ImagesArray = GetImagesArrayByName(ProductNameFromURL);
        var i;
        if(ImagesArray === null)
            return;
        for(i=0;i<ImagesArray.length;i++)
        {
            var ProductImageRef = document.createElement("img");
            ProductImageRef.className = "ProductSecondaryImages";
            ProductImageRef.src = ImagesArray[i].ImageSrc;
            ProductImageRef.onclick = invoke;
            document.getElementsByClassName('ProductSecondaryImagesDiv')[0].appendChild(ProductImageRef);
        }
    }

</script>

<!doctype html>
<html lang="pt-BR">
<head>
    <title>Memories - Página do Produto</title>
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
            width: 50%;
            margin-left: 190px;
            font-weight: normal;
        }
        h3 {
            font-family: Arial;
            text-align: left;
            font-size: 25px;
            margin-top: 0px;
            color: #CB997E;
        }
        h4 {
            text-align: left;
            font-size: 23px;
            margin-top: -15px;
            color: #FAACB7;
            font-weight: normal;
            margin-bottom: 10px;
        }
        h5
        {
            font-size: 17px;
            color: #878787;
            font-family: Arial;
            text-align: left;
            margin-top: 15px;
            font-weight: normal;
        }
        .ProductImageClass
        {
            width: 450px;
            height: 450px;
        }
        .InfoSection
        {
            margin-left: 50px;
        }
        li
        {
            margin-bottom: -10px;
        }
        .ProductSecondaryImages
        {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }
        .ProductSecondaryImagesDiv
        {
            display: flex;
            margin-left: 200px;
            margin-top: 15px;
            width: 420px;
            overflow: auto;
        }
        .TypeButton
        {
            width: 100px;
            height: 50px;
            border-style: hidden;
            margin-bottom: 20px;
            margin-right: 10px;
            color:rgb(255, 255, 255);
            background-color: #FAACB7;
        }
        .LetrasHeader
        {
            font-family: Arial;
            font-size: 18px;
            margin-top: 15px;
            font-weight: bold;
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
    </style>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="site description" />
    <meta name="keywords" content="put here keyoword to find easy by google" />
    <div class="header">
        <p class = "LetrasHeader" style="text-align: right; margin-right: 315px;" >
        <a style="position:absolute" href="Carrinho.php">Meu Carrinho</a>
        </p>
        <p class = "LetrasHeader" style="text-align: left; margin-left: 200px; margin-top: -5px;" >
        <a style="position:absolute" href="Catalogo.php">Voltar para o Catálogo</a>
        </p>
    </div>
</head>
<body style="background-color:rgb(255, 255, 255)">
    <div id="BaseDiv">
        <!-- Logo -->
        <p style="text-align: center;"><img alt="memories logo" src="Images/Logo.png" style="width: 300px;height: 300px;"></p>
        <div style="display: flex;margin-left:200px" id="ProductInfoDiv">
            <!-- Getting product image -->
            <script>
                SetProductImage();
            </script>
            <div id="ProductInfo" class="InfoSection">
                <script>
                    // Name
                    var ProductNameRef = document.createElement("h3");
                    ProductNameRef.innerHTML = ProductNameFromURL;
                    ProductNameRef.id = "ProductName";
                    document.getElementById('ProductInfo').appendChild(ProductNameRef);
                </script>
                <script>
                    // Price
                    var ProductPriceRef = document.createElement("h4");
                    ProductPriceRef.innerHTML = ProductPriceFromURL;
                    ProductPriceRef.id = "ProductPrice";
                    document.getElementById('ProductInfo').appendChild(ProductPriceRef);
                </script>
                <script>
                    // Types

                    invoke2 = (event) => {
                        ProductTypeSelected[0].Tipo = event.target.getAttribute('value');
                        document.getElementById("ProductType1Input").value = ProductTypeSelected[0].Tipo;
                    }
                    
                    invoke3 = (event) => {
                        ProductTypeSelected[1].Tipo = document.getElementById('InputRecado').value;
                        document.getElementById("ProductType2Input").value = ProductTypeSelected[1].Tipo;
                    }

                    var i=0;
                    while(ProductTypeArray[i].ProductTypeFromURL != 'none' && ProductTypeArray[i].ProductTypeFromURL != null)
                    {
                        if(ProductTypeArray[i].ProductTypeFromURL == 'recado')
                        {
                            var InputTypeRef = document.createElement('input');
                            InputTypeRef.type = 'text';
                            InputTypeRef.id = "InputRecado";
                            InputTypeRef.value = 'Digite o recado.';
                            InputTypeRef.onchange = invoke3;
                            document.getElementById('ProductInfo').appendChild(InputTypeRef);
                        }
                        else
                        {
                            var ButtonTypeRef = document.createElement('input');
                            ButtonTypeRef.className = "TypeButton";
                            ButtonTypeRef.type = 'button';
                            ButtonTypeRef.value = ProductTypeArray[i].ProductTypeFromURL;
                            ButtonTypeRef.onclick = invoke2;
                            document.getElementById('ProductInfo').appendChild(ButtonTypeRef);
                        }
                        if(i == ProductTypeArray.length - 1)
                            break;
                        i++;
                    };
                </script>
                <!-- Carrinho -->
                <form id="FormCarrinho" action="">
                    <input id="ProductNameInput" type="hidden" name="ProductNameRef" value="">
                    <input id="ProductType1Input" type="hidden" name="ProductType1Ref" value="">
                    <input id="ProductType2Input" type="hidden" name="ProductType2Ref" value="">
                    <script>
                        document.getElementById("ProductNameInput").value = ProductNameFromURL;
                    </script>
                    <input type="image" src="Images/BotaoComprar.png" style="margin-top:5px;">
                </form>
                <script>
                    if(ProductNameFromURL == 'Box Memories' || ProductNameFromURL == 'Polaroid Branca')
                    {
                        localStorage.removeItem('PhotosInfo');
                        document.getElementById("FormCarrinho").action= "Montar-Fotos.php";
                        //document.getElementById("ProductType1Input").value = "10 fotos";
                    }
                    else if(ProductNameFromURL == 'Tirinhas 3/4 Fotos')
                    {
                        localStorage.removeItem('PhotosInfo');
                        document.getElementById("FormCarrinho").action= "Montar-Tirinhas.php";
                        document.getElementById("ProductType1Input").value = "Tirinha 3 fotos";
                    }
                    else
                        document.getElementById("FormCarrinho").action= "Carrinho.php";
                </script>
                <script>
                    // Description
                    var ProductDescriptionRef = document.createElement("h5");
                    ProductDescriptionRef.innerHTML = ProductDescriptionFromURL;
                    ProductDescriptionRef.id = "ProductDescription";
                    document.getElementById('ProductInfo').appendChild(ProductDescriptionRef);
                </script>
            </div>
        </div>
        <div class="ProductSecondaryImagesDiv">
            <script>
                GetSecondaryImages();
            </script>
        </div>
    </div>
    <div class="footer">
        <p>Footer</p>
    </div>
</body>
</html>
