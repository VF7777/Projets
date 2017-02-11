var TableController = function (view) {
    var table = view.table;
    var this_ = this;
    var copier, coller;
    var redo = new Array();

    if (!(view instanceof TableView))
        throw "Invalid view";

    function findTD(obj) {
        if (!obj || obj.nodeName == "TD") return obj
        else findTD(obj.parentNode);
    };


    this_.selection = null;//selection est la case sélectionné
    this_.clearTD = null;

//Alogorithme pour faire une sélection rectangulaire multiple

    function tdDragHandler(e) {
        this_.dragging = null;
        var td = findTD(e.target);
        var newrowmin = null;
        var newrowmax = null;
        var newcolmin = null;
        var newcolmax = null;

        switch (e.type) {//détecter le type d'événement //console.log(e.type);
            // quand on clique sur la souris
            case "mousedown":
                if (!td) {
                    this_.selection = null;
                    return;
                };
                for (var i = 0; i < view.width; i++) {
                    for (var j = 0; j < view.height; j++) {
                        //console.log(table.rows[j].cells[i].classList);
                        table.rows[j].cells[i].classList.remove("selected");//supprimer attribue "selected" de tous les cases
                    }
                }
                var cell = view.model.getCell(td.col, td.row);
                var form = cell.getFormula();
                view.input.value = form ? '=' + form.toString() : "";
                this_.selection = td;//la case initial
                this_.selection.select(true);
                break;
            // quand relache la souris
            case "mouseup":
                this_.dragging = td; //la case final quand on rêlache le curseur
                this_.dragging.select(true);
                selectRowId = this_.selection.row - 1;//index de ligne de case initial
                dragRowId = this_.dragging.row - 1;//-1 car le nom de la ligne occupe une case
                selectColId = colToIdx(this_.selection.col);
                dragColId = colToIdx(this_.dragging.col);

                //console.log(selectRowId, selectColId);
                //console.log(dragRowId, dragColId);

                if (dragRowId > selectRowId) {//si la position de case initial avant la position de case final
                    newrowmin = selectRowId;
                    newrowmax = dragRowId;
                } else {
                    newrowmin = dragRowId;
                    newrowmax = selectRowId;
                }

                if (dragColId > selectColId) {//si la position de case final avant la position de case initial
                    newcolmin = selectColId;
                    newcolmax = dragColId;
                } else {
                    newcolmin = dragColId;
                    newcolmax = selectColId;
                }
                //console.log(newrowmin,newcolmin);
                //console.log(newrowmax,newcolmax);

                for (var i = newrowmin; i <= newrowmax; i++) {
                    for (var j = newcolmin; j <= newcolmax; j++) {
                        //+1 car le nom de la ligne et colonne occupe une case

                        table.rows[i+1].cells[j+1].classList.add("selected");

                        //console.log(i, j);
                        //console.log(table);

                    }
                }

                break;

        }

        //focus the input.
        setTimeout(function () {
            view.input.focus();
        }, 500);//Le délai

    };

//button pour ajouter des bordures de chaque coté des case sélectioné

    function buttonTout_bordure_ClickHandler(e){

        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    table.rows[j].cells[i].style.borderColor="black";
                }
            }
        }
    }

//button de gestion de bordure le plus gauche

    function buttonGauche_bordure_ClickHandler(e){
        var firstCell, nextCell;
        var arrayMin = new Array();
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    arrayMin.push(i);//pour enregistrer la première colonne à gauche
                    firstCell = Math.min.apply( Math, arrayMin );
                    table.rows[j].cells[firstCell].style.borderLeftColor="black";
                }
            }
        }
    }

//button de gestion de bordure le plus droite

    function buttonDroit_bordure_ClickHandler(e){
        var firstLine,lastLine, lastColumn;
        var arrayLine = new Array();
        var arrayColonne = new Array();
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    arrayColonne.push(i);
                    arrayLine.push(j);//pour enregistrer le premier et dernier colonne sélectioné
                }
            }
        }
        lastColumn= Math.max.apply( Math, arrayColonne );

        firstLine = Math.min.apply( Math, arrayLine );
        lastLine= Math.max.apply( Math, arrayLine );

        for (var j = firstLine; j <= lastLine; j++) {
            table.rows[j].cells[lastColumn].style.borderRightColor = "black";
        }//pour colorer le bordure droite de la dernière colonne selectioné
    }
//button Horizontal bordure

    function buttonHorizontal_bordure_ClickHandler(e){
        var lastLine,firstColumn, lastColumn;
        var arrayMin = new Array();
        var arrayMax = new Array();
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    arrayMin.push(i);//pour enregistrer le premier et dernier colonne sélectioné
                    arrayMax.push(j);
                    table.rows[j].cells[i].style.borderBottomColor="black";
                }
            }
        }
        firstColumn= Math.min.apply( Math, arrayMin );
        lastColumn= Math.max.apply( Math, arrayMin );

        lastLine = Math.max.apply( Math, arrayMax );
        for (var i = firstColumn; i <= lastColumn; i++) {
            table.rows[lastLine].cells[i].style.borderBottomColor = "";
        }//pour ne pas colorer le bordure en bas de la dernière ligne selectioné

    }

//button Vertical bordure

    function buttonVertical_bordure_ClickHandler(e){
        var firstCell, nextCell;
        var arrayMin = new Array();
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    arrayMin.push(i);
                    firstCell = Math.min.apply( Math, arrayMin );
                    table.rows[j].cells[i].style.borderLeftColor="black";
//pour ne pas colorer le bordure gauche de la première ligne selectioné
                    table.rows[j].cells[firstCell].style.borderLeftColor="";
                }
            }
        }
    }
//button Bas bordure

    function buttonBas_bordure_ClickHandler(e){
        var lastLine,firstColumn, lastColumn;
        var arrayMin = new Array();
        var arrayMax = new Array();
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    arrayMin.push(i);//pour enregistrer le premier et dernier colonne sélectioné
                    arrayMax.push(j);
                }
            }
        }
        firstColumn= Math.min.apply( Math, arrayMin );
        lastColumn= Math.max.apply( Math, arrayMin );

        lastLine = Math.max.apply( Math, arrayMax );
        for (var i = firstColumn; i <= lastColumn; i++) {
            table.rows[lastLine].cells[i].style.borderBottomColor = "black";
        }//pour colorer le bordure en bas de la dernière ligne selectioné

    }
//button Haut bordure

    function buttonHaut_bordure_ClickHandler(e){
        var firstLine,firstColumn, lastColumn;
        var arrayMin = new Array();
        var arrayMax = new Array();
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    arrayMin.push(i);//pour enregistrer le premier et dernier colonne sélectioné
                    arrayMax.push(j);
                }
            }
        }
        firstColumn= Math.min.apply( Math, arrayMin );
        lastColumn= Math.max.apply( Math, arrayMin );

        firstLine = Math.min.apply( Math, arrayMax );
        for (var i = firstColumn; i <= lastColumn; i++) {
            table.rows[firstLine].cells[i].style.borderTopColor = "black";
        }//pour colorer le bordure en haut de la dernière ligne selectioné


    }

//buttonNone_bordure

    function buttonNone_bordure_ClickHandler(e){

        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if (table.rows[j].cells[i].classList=="selected") {
                    table.rows[j].cells[i].style.borderColor="";
                }
            }
        }
    }

//Button de confiremation

    function buttonClickHandler(e) {
        var td = this_.selection;
        if (!td) return;
        var s = view.input.value;
        var cell = view.model.getCell(td.col, td.row);

        //test if it is a formula:
        var res = s.match(/^=(.*)$/);
        try {
            var address = td.col + "," + td.row;
            if (res)
                cell.setFormula(res[1], address);
            else
                cell.setFormula('"' + s + '"', address);
        } catch (e) {
            alert(e);
        }
    };

//Button pour changer text en gras

    function buttonGras_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;

        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if(table.rows[j].cells[i].classList.contains("selected")) {

                    //console.log(table.rows[j].cells[i].style.fontWeight);

                    if (table.rows[j].cells[i].style.fontWeight != "bold") {
                        table.rows[j].cells[i].style.fontWeight = "bold";
                    }
                    else {
                        table.rows[j].cells[i].style.fontWeight = "normal";
                    }
                }
            }
        }
    };

//Button pour changer text en Italique

    function buttonItalique_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;

        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if(table.rows[j].cells[i].classList.contains("selected")) {

                    if (table.rows[j].cells[i].style.fontStyle != "italic") {
                        table.rows[j].cells[i].style.fontStyle = "italic";
                    }
                    else {
                        table.rows[j].cells[i].style.fontStyle = "normal";
                    }
                }
            }
        }

    };

//Button pour souligner les text

    function buttonSouligne_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if(table.rows[j].cells[i].classList.contains("selected")) {

                    if (table.rows[j].cells[i].style.textDecoration != "underline") {
                        table.rows[j].cells[i].style.textDecoration = "underline";
                    }
                    else {
                        table.rows[j].cells[i].style.textDecoration = "";
                    }
                }
            }
        }
    };

//Button pour changer la couleur de text

    function changeTextCouleur_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;
        var textColor = document.getElementById("TextColor").value;
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if(table.rows[j].cells[i].classList.contains("selected")){
                    table.rows[j].cells[i].style.color = textColor;

                }

            }
        }

    };

//Button pour changer la couleur de fond

    function changeFondCouleur_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;
        var fondColor = document.getElementById("BackgroundColor").value;
        for (var i = 0; i < view.width; i++) {
            for (var j = 0; j < view.height; j++) {
                if(table.rows[j].cells[i].classList.contains("selected")) {
                    table.rows[j].cells[i].style.backgroundColor = fondColor;
                }
            }
        }

    };

    //Button pour copier

    function buttonCopier_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;

        var cell = view.model.getCell(td.col, td.row);
        var form = cell.getFormula();
        view.input.value = form ? '=' + form.toString() : "";
        copier = form.toString();

    };

    //Button pour coller

    function buttonColler_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;
        var cell = view.model.getCell(td.col, td.row);

        var address = td.col + "," + td.row;

        cell.setFormula(copier, address);

    };

    //Button pour couper

    function buttonCouper_ClickHandler(e) {

        var td = this_.selection;
        if (!td) return;
        var address = td.col + "," + td.row;
        console.log(address);
        selectRowId = td.row;//index de ligne de case initial
        selectColId = colToIdx(td.col)+1;
        console.log(selectRowId,selectColId);

        var cell = view.model.getCell(td.col, td.row);
        var form = cell.getFormula();
        copier = form.toString();
        table.rows[selectRowId].cells[selectColId].innerHTML = "";
    };


    view.button.addEventListener("click", buttonClickHandler);

//button de gestion de style de text

    view.buttonGras.addEventListener("click", buttonGras_ClickHandler);

    view.buttonItalique.addEventListener("click", buttonItalique_ClickHandler);

    view.buttonSouligne.addEventListener("click", buttonSouligne_ClickHandler);

//button de couleur

    view.inputTextCouleur.addEventListener("input", changeTextCouleur_ClickHandler);

    view.inputBackgroundCouleur.addEventListener("input", changeFondCouleur_ClickHandler);

//button pour faire une sélection rectangulaire multiple

    view.table.addEventListener("mousedown", tdDragHandler);

    view.table.addEventListener("mouseup", tdDragHandler);

//button de gestion de bordure

    view.buttonTout_bordure.addEventListener("click", buttonTout_bordure_ClickHandler);

    view.buttonVertical_bordure.addEventListener("click", buttonVertical_bordure_ClickHandler);

    view.buttonHorizontal_bordure.addEventListener("click", buttonHorizontal_bordure_ClickHandler);

    view.buttonBas_bordure.addEventListener("click", buttonBas_bordure_ClickHandler);

    view.buttonHaut_bordure.addEventListener("click", buttonHaut_bordure_ClickHandler);

    view.buttonGauche_bordure.addEventListener("click", buttonGauche_bordure_ClickHandler);

    view.buttonDroit_bordure.addEventListener("click", buttonDroit_bordure_ClickHandler);

    view.buttonNone_bordure.addEventListener("click", buttonNone_bordure_ClickHandler);


    //button de gestion de bordure

    view.buttonCopier.addEventListener("click", buttonCopier_ClickHandler);

    view.buttonColler.addEventListener("click", buttonColler_ClickHandler);

    view.buttonCouper.addEventListener("click", buttonCouper_ClickHandler);



    view.input.addEventListener("keypress", function (e) {
        if (e.keyCode == 13) //[enter]
            buttonClickHandler(e);
    });

}
//Les fonction pour obtenir les indices

    var colToIdx = function (s) {
        var res = 0;
        for (var i = 0; i < s.length; i++) {
            res *= 26;
            res += (s.charCodeAt(i) - 64);
    }
    return (res - 1);
    };

    var idxToCol = function (i) {
        var res = "";
        var n = i + 1;
        var c = 0;
        while (n > 0) {
            c = n % 26;
            c = c == 0 ? 26 : c;
            res = String.fromCharCode(c + 64) + res;
            n = Math.trunc((n - c) / 26);
        };
    return res;
    };

    var rowToIdx = function (r) {
        return r - 1;
    };

    var idxToRow = function (i) {
        return (i + 1).toString();
    };