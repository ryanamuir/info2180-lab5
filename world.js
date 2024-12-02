document.addEventListener('DOMContentLoaded', function(){
    document.getElementById('lookup').addEventListener('click', function() {
        const searchvalue = document.getElementById('country').value.trim();
        console.log(searchvalue)
        fetch('http://localhost/info2180-lab5/world.php?query=' + encodeURIComponent(searchvalue))
            .then(response => response.text())
            .then(data => {
                console.log(data);
                document.getElementById('result').innerHTML = data;
         })
            .catch(error => {
                console.error('Error:', error);
                document.getElementsByClassName('result').innerText = 'An error occurred while fetching data.';
         });
   });
});