
$(document).ready(function() {
    $(".nav-item").click(function(e) {
        console.log("User has clicked on the menu link");
        
        let clicked = 'metrics/clicked/navigation/' + $(this).text();
        
        window.axios.get(clicked).then((response)=>{
            console.log(response)
            console.log(error.response.data)
        }).catch((error)=>{
        })
    });
    
    e.preventDefault();
});