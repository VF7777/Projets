var TableView = function (id, tableModel) {

    this.model = tableModel;
    this.div = document.createElement("div");
    this.div.id = "spreadsheet-div";
    this.width = tableModel.width;
    this.height = tableModel.height;

    var target = document.getElementById(id);
    if (target)
        target.appendChild(this.div);

    this.input = document.createElement("input");
    this.input.type = "text";
    this.div.appendChild(this.input);

    this.button = document.createElement("button");
    this.button.innerHTML = "&#10003;";
    this.div.appendChild(this.button);

//Fonction de Style de Text : Gras, Italique et Souligné

    this.divS = document.createElement("div");
    this.divS.id = "divStyle";
    this.div.appendChild(this.divS);

    this.buttonGras = document.createElement("input");
    this.buttonGras.type = "image";
    this.buttonGras.src = "./docs/img/gras.png";
    this.buttonGras.width = "30";
    this.buttonGras.height = "30";
    this.divS.appendChild(this.buttonGras);

    this.buttonItalique = document.createElement("input");
    this.buttonItalique.type = "image";
    this.buttonItalique.src = "./docs/img/italique.png";
    this.buttonItalique.width = "30";
    this.buttonItalique.height = "30";
    this.divS.appendChild(this.buttonItalique);

    this.buttonSouligne = document.createElement("input");
    this.buttonSouligne.type = "image";
    this.buttonSouligne.src = "./docs/img/text-underline.png";
    this.buttonSouligne.width = "30";
    this.buttonSouligne.height = "30";
    this.divS.appendChild(this.buttonSouligne);

//Fonction de choix de couleur de text

    this.divT = document.createElement("div");
    this.divT.id = "divText";
    this.div.appendChild(this.divT);

    this.iconTextCouleur = document.createElement("input");
    this.iconTextCouleur.type = "image";
    this.iconTextCouleur.src = "./docs/img/font-color-icon.png";
    this.iconTextCouleur.width = "28";
    this.iconTextCouleur.height = "28";
    this.divT.appendChild(this.iconTextCouleur);

    this.inputTextCouleur = document.createElement("input");
    this.inputTextCouleur.id = "TextColor";
    this.inputTextCouleur.type = "color";
    this.inputTextCouleur.setAttribute("list","textColors");
    this.divT.appendChild(this.inputTextCouleur);

    this.dataList = document.createElement("datalist");
    this.dataList.id = "textColors";
    this.divT.appendChild(this.dataList);

//Fonction de choix de couleur de fond

    this.iconBackgroundCouleur = document.createElement("input");
    this.iconBackgroundCouleur.type = "image";
    this.iconBackgroundCouleur.src = "./docs/img/Actions-fill-color-icon.png";
    this.iconBackgroundCouleur.width = "28";
    this.iconBackgroundCouleur.height = "28";
    this.divT.appendChild(this.iconBackgroundCouleur);

    this.inputBackgroundCouleur = document.createElement("input");
    this.inputBackgroundCouleur.id = "BackgroundColor";
    this.inputBackgroundCouleur.type = "color";
    this.inputBackgroundCouleur.setAttribute("list","textColors2");
    this.divT.appendChild(this.inputBackgroundCouleur);

    this.dataList2 = document.createElement("datalist");
    this.dataList2.id = "textColors2";
    this.divT.appendChild(this.dataList2);

//Fonction de bordure

    this.divB = document.createElement("div");
    this.divB.id = "divBorder";
    this.div.appendChild(this.divB);

    this.buttonTout_bordure = document.createElement("input");
    this.buttonTout_bordure.type = "image";
    this.buttonTout_bordure.src = "./docs/img/all_border.png";
    this.buttonTout_bordure.width = "28";
    this.buttonTout_bordure.height = "28";
    this.divB.appendChild(this.buttonTout_bordure);

    this.buttonHorizontal_bordure = document.createElement("input");
    this.buttonHorizontal_bordure.type = "image";
    this.buttonHorizontal_bordure.src = "./docs/img/horizontal-inside-border.png";
    this.buttonHorizontal_bordure.width = "28";
    this.buttonHorizontal_bordure.height = "28";
    this.divB.appendChild(this.buttonHorizontal_bordure);

    this.buttonVertical_bordure = document.createElement("input");
    this.buttonVertical_bordure.type = "image";
    this.buttonVertical_bordure.src = "./docs/img/vertical-border.png";
    this.buttonVertical_bordure.width = "28";
    this.buttonVertical_bordure.height = "28";
    this.divB.appendChild(this.buttonVertical_bordure);

    this.buttonBas_bordure = document.createElement("input");
    this.buttonBas_bordure.type = "image";
    this.buttonBas_bordure.src = "./docs/img/bottom-border-icon-clip-art.png";
    this.buttonBas_bordure.width = "28";
    this.buttonBas_bordure.height = "28";
    this.divB.appendChild(this.buttonBas_bordure);

    this.buttonHaut_bordure = document.createElement("input");
    this.buttonHaut_bordure.type = "image";
    this.buttonHaut_bordure.src = "./docs/img/ftborder-top.png";
    this.buttonHaut_bordure.width = "28";
    this.buttonHaut_bordure.height = "28";
    this.divB.appendChild(this.buttonHaut_bordure);

    this.buttonGauche_bordure = document.createElement("input");
    this.buttonGauche_bordure.type = "image";
    this.buttonGauche_bordure.src = "./docs/img/border-left-clip-art.png";
    this.buttonGauche_bordure.width = "28";
    this.buttonGauche_bordure.height = "28";
    this.divB.appendChild(this.buttonGauche_bordure);

    this.buttonDroit_bordure = document.createElement("input");
    this.buttonDroit_bordure.type = "image";
    this.buttonDroit_bordure.src = "./docs/img/right-border-icon-clip-art.png";
    this.buttonDroit_bordure.width = "28";
    this.buttonDroit_bordure.height = "28";
    this.divB.appendChild(this.buttonDroit_bordure);

    this.buttonNone_bordure = document.createElement("input");
    this.buttonNone_bordure.type = "image";
    this.buttonNone_bordure.src = "./docs/img/none-border.png";
    this.buttonNone_bordure.width = "28";
    this.buttonNone_bordure.height = "28";
    this.divB.appendChild(this.buttonNone_bordure);

// Ajouter u div pour changer la ligne dans la page

    this.divSpace = document.createElement("div");
    this.divSpace.id = "divChangerLigne";
    this.divSpace.innerHTML = "&nbsp";
    this.div.appendChild(this.divSpace);

// Fonction de copier, coller, couper

    this.divCopier = document.createElement("div");
    this.divCopier.id = "divCopy";
    this.div.appendChild(this.divCopier);

    this.buttonCopier = document.createElement("input");
    this.buttonCopier.type = "image";
    this.buttonCopier.src = "./docs/img/copier.png";
    this.buttonCopier.width = "30";
    this.buttonCopier.height = "30";
    this.divCopier.appendChild(this.buttonCopier);

    this.buttonColler = document.createElement("input");
    this.buttonColler.type = "image";
    this.buttonColler.src = "./docs/img/coller.png";
    this.buttonColler.width = "30";
    this.buttonColler.height = "30";
    this.divCopier.appendChild(this.buttonColler);

    this.buttonCouper = document.createElement("input");
    this.buttonCouper.type = "image";
    this.buttonCouper.src = "./docs/img/couper.png";
    this.buttonCouper.width = "30";
    this.buttonCouper.height = "30";
    this.divCopier.appendChild(this.buttonCouper);

    // Fonction de annuler, refaire et rechercher, pas de temps le faire


    /*    this.buttonAnnuler = document.createElement("input");
        this.buttonAnnuler.type = "image";
        this.buttonAnnuler.src = "./docs/img/annuler.png";
        this.buttonAnnuler.width = "30";
        this.buttonAnnuler.height = "30";
        this.divCopier.appendChild(this.buttonAnnuler);

        this.buttonRefaire = document.createElement("input");
        this.buttonRefaire.type = "image";
        this.buttonRefaire.src = "./docs/img/refaire.png";
        this.buttonRefaire.width = "30";
        this.buttonRefaire.height = "30";
        this.divCopier.appendChild(this.buttonRefaire);

        this.buttonRechercher = document.createElement("input");
        this.buttonRechercher.type = "image";
        this.buttonRechercher.src = "./docs/img/rechercher.png";
        this.buttonRechercher.width = "30";
        this.buttonRechercher.height = "30";
        this.divCopier.appendChild(this.buttonRechercher);*/

    this.table = document.createElement("table");
    this.div.appendChild(this.table);

};


TableView.prototype.createTable = function () {//creer la tableur
    var model = this.model;
    var table = this.table;


    //Clear the table

    for (var c = table.firstChild; c != null; c = c.nextSibling)
        table.removeChild(c);


    var thead = document.createElement("thead");
    table.appendChild(thead);

    var tr = document.createElement("tr");
    thead.appendChild(tr);
    tr.appendChild(document.createElement("th"));

    model.forEachCol(function (c) {
        var th = document.createElement("th");
        th.appendChild(document.createTextNode(c));
        tr.appendChild(th);
    });

    var tbody = document.createElement("tbody");
    table.appendChild(tbody);

    model.forEachRow(function (j) {
        var tr = document.createElement("tr");
        tbody.appendChild(tr);
        var td = document.createElement("td");
        var text = document.createTextNode(j);
        td.appendChild(text);
        tr.appendChild(td);
        model.forEachCol(function (i) {
            var cell = model.getCell(i, j);
            var td = document.createElement("td");
            cell.setView(td);

            //monkey patching
            td.row = j;
            td.col = i;

            td.notify = function (cell) {
                td.firstChild.nodeValue = cell.getValue();
            };

            td.isSelected = function () {
                return this.classList.contains("selected");
            };

            //classList est une liste continet les nom de clases
            td.select = function (b) {
                if (b)
                    this.classList.add("selected");
                else
                    this.classList.remove("selected");
            };

            var text = document.createTextNode(cell.getValue());
            td.appendChild(text);
            tr.appendChild(td);
        });

    });


};
