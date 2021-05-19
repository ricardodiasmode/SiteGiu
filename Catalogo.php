<script>
    // Creating arrays of info
    let ProductInfo = [
        {
            ProductImage: "Images/Catalogo/BoxMemories.jpeg",
            ProductName: "Box Memories",
            ProductPrice: "R$ 55,00 - 85,00",
            ProductDescription: "É uma caixinha em MDF, com dobradiça no tamanho 15x15.<br>Contém,<br><li>1 garrafinha de vidro para recado</li><br><li>1 porta retrato para Polaroid</li><br><li>1 varal + 10 pregadores</li><br><li>Pack de Polaroids (10, 20, 30) - sua escolha.</li><br>Box memories c/ 10 fotos - $55,00<br>Box memories c/ 20 fotos - $70,00<br>Box memories c/ 30 fotos - $85,00",
            ProductType1: "10 fotos",
            ProductType2: "20 fotos",
            ProductType3: "30 fotos",
            ProductType4: "recado",
            ProductType5: "none",
            ProductType6: "none",
        },
        {
            ProductImage: "Images/Catalogo/ScrapBook/ScrapBookCapa.jpeg",
            ProductName: "ScrapBook",
            ProductPrice: "R$ 35,00 - 80,00",
            ProductDescription: "Tamanho PP, P e M<br>*Não inclui as fotos",
            ProductType1: "PP Preto",
            ProductType2: "P Preto",
            ProductType3: "M Preto",
            ProductType4: "PP Kraft",
            ProductType5: "P Kraft",
            ProductType6: "M Kraft",
        },
        {
            ProductImage: "images/Catalogo/MemoryBoard.jpeg",
            ProductName: "Memory Board",
            ProductPrice: "R$ 28,00",
            ProductDescription: "Tamanho 40x40<br>Consulte cores disponíveis<br>*Não inclui as fotos",
            ProductType1: "none",
            ProductType2: "none",
            ProductType3: "none",
            ProductType4: "none",
            ProductType5: "none",
            ProductType6: "none",
        },
        {
            ProductImage: "images/Catalogo/VaralComum.jpeg",
            ProductName: "Varal Comum",
            ProductPrice: "R$ 7,00",
            ProductDescription: "Vem com 10 mini pregadores<br>*Não inclui as fotos",
            ProductType1: "none",
            ProductType2: "none",
            ProductType3: "none",
            ProductType4: "none",
            ProductType5: "none",
            ProductType6: "none",
        },
        {
            ProductImage: "images/Catalogo/VaralLed.jpeg",
            ProductName: "Varal Led",
            ProductPrice: "R$ 35,00",
            ProductDescription: "*Não inclui as fotos",
            ProductType1: "none",
            ProductType2: "none",
            ProductType3: "none",
            ProductType4: "none",
            ProductType5: "none",
            ProductType6: "none",
        },
        {
            ProductImage: "images/Catalogo/ModelosFotos.jpeg",
            ProductName: "Polaroid Branca",
            ProductPrice: "R$ 1,50 - 3,00",
            ProductDescription: "Mínimo de 10 fotos.<br><li>Polaroid borda branca</li><br><li>Polaroid com legenda</li><br><li>Polaroid com música</li><br><li>Polaroid com imã</li><br>",
            ProductType1: "10 fotos",
            ProductType2: "20 fotos",
            ProductType3: "30 fotos",
            ProductType4: "none",
            ProductType5: "none",
            ProductType6: "none",
        },
        {
            ProductImage: "images/Catalogo/Tirinha3Fotos.jpeg",
            ProductName: "Tirinhas 3/4 Fotos",
            ProductPrice: "R$ 3,00 - 3,50",
            ProductDescription: "*Não há mínimo e está fora do cálculo das fotos polaroid",
            ProductType1: "Tirinha 3 fotos",
            ProductType2: "Tirinha 4 fotos",
            ProductType3: "none",
            ProductType4: "none",
            ProductType5: "none",
            ProductType6: "none",
        }
    ];

    function GenerateProducts(line, FirstIndex, LastIndex)
    {
        var i;
        for(i = FirstIndex; i<LastIndex;i++)
        {
            if( i < ProductInfo.length)
            {
                var SpanRef = document.createElement("span");
                SpanRef.className = "CatalogoContainer";

                var FormRef = document.createElement("form");
                FormRef.action = "ProductPage.php";
                SpanRef.appendChild(FormRef);

                /* Product things */
                var InputProductImage = document.createElement("input");
                InputProductImage.type = "hidden";
                InputProductImage.name = "ProductImage";
                InputProductImage.value = ProductInfo[i].ProductImage;
                FormRef.appendChild(InputProductImage);

                var InputProductName = document.createElement("input");
                InputProductName.type = "hidden";
                InputProductName.name = "ProductName";
                InputProductName.value = ProductInfo[i].ProductName;
                FormRef.appendChild(InputProductName);

                var InputProductPrice = document.createElement("input");
                InputProductPrice.type = "hidden";
                InputProductPrice.name = "ProductPrice";
                InputProductPrice.value = ProductInfo[i].ProductPrice;
                FormRef.appendChild(InputProductPrice);

                var InputProductDescription = document.createElement("input");
                InputProductDescription.type = "hidden";
                InputProductDescription.name = "ProductDescription";
                InputProductDescription.value = ProductInfo[i].ProductDescription;
                FormRef.appendChild(InputProductDescription);

                /* Types */

                var InputProductType1 = document.createElement("input");
                InputProductType1.type = "hidden";
                InputProductType1.name = "ProductType1";
                InputProductType1.value = ProductInfo[i].ProductType1;
                FormRef.appendChild(InputProductType1);

                var InputProductType2 = document.createElement("input");
                InputProductType2.type = "hidden";
                InputProductType2.name = "ProductType2";
                InputProductType2.value = ProductInfo[i].ProductType2;
                FormRef.appendChild(InputProductType2);

                var InputProductType3 = document.createElement("input");
                InputProductType3.type = "hidden";
                InputProductType3.name = "ProductType3";
                InputProductType3.value = ProductInfo[i].ProductType3;
                FormRef.appendChild(InputProductType3);

                var InputProductType4 = document.createElement("input");
                InputProductType4.type = "hidden";
                InputProductType4.name = "ProductType4";
                InputProductType4.value = ProductInfo[i].ProductType4;
                FormRef.appendChild(InputProductType4);

                var InputProductType5 = document.createElement("input");
                InputProductType5.type = "hidden";
                InputProductType5.name = "ProductType5";
                InputProductType5.value = ProductInfo[i].ProductType5;
                FormRef.appendChild(InputProductType5);

                var InputProductType6 = document.createElement("input");
                InputProductType6.type = "hidden";
                InputProductType6.name = "ProductType6";
                InputProductType6.value = ProductInfo[i].ProductType6;
                FormRef.appendChild(InputProductType6);

                /* Image Input */
                var InputProductImageToShow = document.createElement("input");
                InputProductImageToShow.type = "image";
                InputProductImageToShow.className = "ImageContainer";
                InputProductImageToShow.src = ProductInfo[i].ProductImage;
                FormRef.appendChild(InputProductImageToShow);

                var ProductNameToShow = document.createElement("H3");
                ProductNameToShow.appendChild(document.createTextNode(ProductInfo[i].ProductName));
                SpanRef.appendChild(ProductNameToShow);

                var ProductPriceToShow = document.createElement("H4");
                ProductPriceToShow.appendChild(document.createTextNode(ProductInfo[i].ProductPrice));
                SpanRef.appendChild(ProductPriceToShow);
                
                if(line === 1)
                {
                    document.getElementById('Linha01Catalogo').appendChild(SpanRef);
                }
                else
                {
                    document.getElementById('Linha02Catalogo').appendChild(SpanRef);
                }
                    }
                }
    }
</script>

<!doctype html>
<html lang="pt-BR">
<head>
    <title>Memories - Catálogo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="description" content="site description" />
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
            width: 50%;
            margin-left: 190px;
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
            margin-top: -10px;
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
        .LinhaCatalogo
        {
            margin-top: -20px;
            display: flex;
            width: 50%;
            margin-left: 175px;
        }
        .CatalogoContainer 
        {
            display: block;
            margin: 0;
            margin-left: 15px;
        }
        .ImageContainer
        {
            padding-top: 15px;
            display: block;
            margin: auto;
            width: 220px;
            height: 220px;
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

    </style>
    <div class="header">
        <p class = "LetrasHeader"><a href="Carrinho.php">Meu Carrinho</a></p>
    </div>
</head>
<body style="background-color:rgb(255, 255, 255)">
    <div id="BaseDiv">
        <!-- Logo -->
        <p style="text-align: center;"><img alt="memories logo" src="Images/Logo.png" style="width: 300px;height: 300px;"></p>
        <!-- Texto antes da linha -->
        <h2>Nossos produtos:</h2>
        <!-- Linha 01 catalogo -->
        <div id="Linha01Catalogo" class="LinhaCatalogo">
            <script>
                GenerateProducts(1, 0, 4);
            </script>
        </div>
        <!-- Linha 02 catalogo -->
        <div id="Linha02Catalogo" class="LinhaCatalogo" style="margin-top:-10px">
            <script>
                GenerateProducts(2, 4, 7);
            </script>
        </div>
    </div>
    <div class="footer">
        <p>Footer</p>
    </div>
    <script>
        if(localStorage.getItem('FezPedido') == 'true')
        {
            localStorage.clear();
        }
    </script>

</body>
</html>
