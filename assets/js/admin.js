document.addEventListener("DOMContentLoaded", (event) => {

    function buildToCards() {

        const toCardsDiv = document.querySelector("#operator-list")

        fetch("process/get_to.php")
            .then(response => {
                if (response.ok) {
                    return response.json()
                } else {
                    console.log("Mauvaise réponse du réseau (process/get_to.php)");
                }
                return response.json()
            })
            .then(json => {
                json.forEach(element => {
                    toCardsDiv.innerHTML += `<h4>${element['name']}</h4>
                <a href="${element['link']}">Site web de l'operateur</a>
                <a href="manageto.php?id=${element['id']}">Modifier</a>
                <br>`
                });
            })
            .catch(function (error) {
                console.log(
                    "Il y a eu un problème avec l'opération fetch : " + error.message,
                );
            });
    }
    buildToCards()
})