document.addEventListener("DOMContentLoaded", (event) => {

    function deleteDestination(id) {
        const data = {
            id: id
        }
        fetch("process/delete_destination.php", {
            method: "POST",
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify(data),
            
        });
        
        
        

    }
})