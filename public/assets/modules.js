
$(document).ready(function() {
    $(".nav-item").click(function(e) {
        console.log("User has clicked on the menu link");
        e.preventDefault();

        let clicked = 'metrics/clicked/navigation/' + $(this).text();

        window.axios.get(clicked).then((response)=>{
            console.log(response)
        }).catch((error)=>{
            console.log(error.response.data)
        })
    });
});