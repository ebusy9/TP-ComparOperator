document.addEventListener("DOMContentLoaded", (event) => {

    async function deleteDestination(id) {

        const data = {
            id: id
        }

        fetch("process/delete_destination.php", {
            method: "POST",
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify(data),
        })
            .then(response => {
                if (response.ok) {
                    return response.json()
                } else {
                    console.log("Mauvaise réponse du réseau (process/get_to.php)");
                }
                return response.json()
            })

            .then(json => {

            })

            .catch(function (error) {
                console.log(
                    "Il y a eu un problème avec l'opération fetch : " + error.message,
                )
            })

    }
})