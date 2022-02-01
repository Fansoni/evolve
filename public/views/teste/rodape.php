    </body>
</html>

<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
<script>
    $('#cidade-result').hide();
    function buscarCidade() {
        console.log($('#cidade-field').val());
        var url = 'http://localhost/evolve-teste2/teste/ajax/buscaIbgeNome/' + $('#cidade-field').val();
        $('#cidade-result').empty();
        if($('#cidade-field').val()){
            $('#cidade-result').show();
        }else{
            $('#cidade-result').hide();
        }
        $.ajax({
            type: 'GET',
            url: url,
            dataType: "json",
            success:function(data){
                if(data.result){
                    data.result.forEach(element => {
                        $('#cidade-result').append('<li codigo="'+ element.id +'">' + element.nome + '</li>');
                    });
                    $('#cidade-result li').on('click', function() {
                        $('#cidade-field').val($(this).text());
                        $('#cidade-result').hide();
                    });
                }else{
                    $('#cidade-result').append('<li codigo="">Sem resultados</li>');    
                }
            },
            error:function(error){
                $('#cidade-result').append('<li codigo="">Sem resultados</li>');
            }
        });
    }
</script>
   