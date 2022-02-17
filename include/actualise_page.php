<script>
    setInterval('load_message()', 500);
    function load_message(){
        $('#message').load('load_message.php');
    }
</script>