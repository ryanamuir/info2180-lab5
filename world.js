document.addEventListener('DOMContentLoaded', function() {
    // Lookup Country Button
    document.getElementById('lookupCountry').addEventListener('click', function() {
        const searchvalue = document.getElementById('country').value.trim();
        if (searchvalue === "") {
            alert("Please enter a country name.");
            return;
        }
        console.log("Looking up countries for:", searchvalue);
        fetch('http://localhost/info2180-lab5/world.php?query=' + encodeURIComponent(searchvalue))
            .then(response => response.text())
            .then(data => {
                console.log(data);
                document.getElementById('result').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = "An error occurred while fetching data.";
            });
    });

    // Lookup City Button
    document.getElementById('lookupCity').addEventListener('click', function() {
        const searchvalue = document.getElementById('country').value.trim();
        if (searchvalue === "") {
            alert("Please enter a country name.");
            return;
        }
        console.log("Looking up cities for:", searchvalue);
        fetch('http://localhost/info2180-lab5/world.php?query=' + encodeURIComponent(searchvalue) + "&lookup=cities")
            .then(response => response.text())
            .then(data => {
                console.log(data);
                document.getElementById('result').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('result').innerHTML = "An error occurred while fetching data.";
            });
    });
});
