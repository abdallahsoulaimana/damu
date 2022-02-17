<script>
    function imprimer(divName){
        var restorepage=document.body.innerHTML;
        var printContent=document.getElementById(divName).innerHTML;
        
        document.body.innerHTML=printContent;
        window.print();
        document.body.innerHTML=restorepage;
    }
</script>