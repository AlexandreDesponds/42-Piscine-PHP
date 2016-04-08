var formAction = 0;

function form(event){
    event.preventDefault();
    var question = document.querySelector("#form input[type='text']").value;
    var reponse = document.querySelector("#reponse");
    var randomQuestion = new Array(
        "Il fait chaud aujourd'hui non ?",
        "J'aime pas les gens qui parle en e3, et toi ?",
        "Les machines à café fonctionne ?",
        "Tu es quel niveau ?",
        "Tu veux pas aller faire un pingpong ?"
    );
    switch(formAction) {
        case 0:
            if (question.indexOf("non") > -1) {
                reponse.innerHTML = "Quel est ton login alors ?";
                formAction = 10;
            } else if (question.indexOf("oui") > -1) {
                reponse.innerHTML = "Cool, tu veux pas faire 42 ?";
                formAction = 20;
            } else {
                reponse.innerHTML = "J'ai pas compris :/";
            }
            break;
        case 10:
            reponse.innerHTML = "Bonjour " + question + " ! Tu fais la piscine PHP ?";
            formAction = 11;
            break;
        case 11:
            if (question.indexOf("non") > -1) {
                reponse.innerHTML = "Ah, pourquoi tu me corrige alors ?";
                formAction = 12;
            } else if (question.indexOf("oui") > -1) {
                reponse.innerHTML = "Cool, Tu as fait combien d'exercice du jours 00 ?";
                formAction = 13;
            } else {
                reponse.innerHTML = "J'ai pas compris :/";
            }
            break;
        case 12:
                reponse.innerHTML = "Ah okay, alors bon jeux :)";
                formAction = 100;
            break;
        case 13:
            if (question.indexOf("1") > -1)
                reponse.innerHTML = "Ah, demande moi, je peux t'aider !";
            if (question.indexOf("2") > -1)
                reponse.innerHTML = "Mandeleiev de mes couilles... Tellement chiant cet exercice.";
            if (question.indexOf("3") > -1)
                reponse.innerHTML = "Ta vu, le site de 'exercice 3 est trop moche ahah";
            if (question.indexOf("4") > -1)
                reponse.innerHTML = "Simpa le menu en CSS :)";
            if (question.indexOf("5") > -1)
                reponse.innerHTML = "T'es un PGM";
            formAction = 100;
            break;
        case 20:
            if (question.indexOf("non") > -1) {
                reponse.innerHTML = "Ah, pourquoi, tu vera c'est cool ?";
                formAction = 21;
            } else if (question.indexOf("oui") > -1) {
                reponse.innerHTML = "Alors bonne chance :D Tu la fais quel mois ?";
                formAction = 22;
            } else {
                reponse.innerHTML = "J'ai pas compris :/";
            }
            break;
        case 21:
            reponse.innerHTML = "Je suis pas d'accord avec toi :/ Je part, a+";
            formAction = 100;
            break;
        case 22:
            reponse.innerHTML = "Alors bonne chance :)";
            formAction = 100;
            break;
        case 100:
            reponse.innerHTML = randomQuestion[Math.floor((Math.random() * randomQuestion.length))];
            formAction = 100;
            break;
    }
    document.querySelector("#form input[type='text']").value = " ";
}

window.onload = function () {
    document.querySelector("#form").addEventListener("submit", form);
}