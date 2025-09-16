<?PHP

    global $CONFIG;    
    ob_start(); 
?>

<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/table.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/form.css">    
<link type="text/css" rel="stylesheet" href="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/css/AdminLTE.css">    
<script type="text/javascript" src="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/js/messages_ca.js"></script>
<script type="text/javascript" src="<?php echo SCM_PATH_THEME.SCM_THEME; ?>/js/jquery.validator.js"></script>  

<?PHP 
    $idEsdeveniment = $_REQUEST['esdeveniment'];
    $esdeveniment = New Esdeveniment($idEsdeveniment);    
    
    print('<input type="hidden" id ="idEsdeveniment" name="idEsdeveniment" value="' .$idEsdeveniment. '"/>');        
?>        


<script type="text/javascript">

    var counter = 0;
    var idEsdeveniment = document.getElementById('idEsdeveniment').value;
    <?PHP echo 'var ruta_imatges ="' .SCM_PATH_THEME.SCM_THEME.'"'; ?>
            
    $(document).ready(function(){

        $("#add").on('click', function(){
                
            pos = ++counter;
                
            var tds = '<tr role="row" class="odd" onmouseover="this.className=\'resaltar\'", onmouseout="this.className=\'null\'">';
            tds += '<td class="centro separadorLineaH" width=5%><div id="posicio_'+pos+'">'+pos+'</div></td>';
            tds += '<td class="centro separadorLineaH" width=15%><div id="arribada_'+pos+'">'+ara('all')+'</div></td>';
            tds += '<td class="centro separadorLineaH" width=8%><div id="temps_'+pos+'">'+tempsRellotge()+'</div></td>';
            tds += '<td class="centro separadorLineaH" width=5%><input type="text" id="dorsal_'+pos+'" size="6" maxlength="4" onblur=javascript:carregaParticipant("'+pos+'")></td>';
            tds += '<td class="izquierda separadorLineaH" width=25%><div id="participant_'+pos+'"></div></td>';
            tds += '<td class="izquierda separadorLineaH" width=15%><div id="sexe_'+pos+'"></div></td>';            
            tds += '<td class="izquierda separadorLineaH" width=15%><div id="localitat_'+pos+'"></div></td>';
            tds += '<td class="centro separadorLineaH diploma" width=3%><a id="diploma_'+pos+'" target="_blank"><img src="'+ruta_imatges+'images/script.png"></a></td>';            
            tds += '<td class="centro separadorLineaH eliminar" width=3%><a class="elimina"><img src="'+ruta_imatges+'images/bin.png"></a></td>';
            tds += '</tr>';

            $("#dataTable").append(tds);
        });
            
        // Evento que selecciona la fila y la elimina
        $(document).on("click",".eliminar",function(){
            resposta = confirm('Vols eliminar la fila?'); 
            if (resposta){ 
                var parent = $(this).parent();
                var dorsal = $(this).parent().find('input:first').val();
                var querystr = 'esdeveniment='+idEsdeveniment+'&control=99&dorsal='+dorsal;
                
                $(parent).remove(); // esborrem la fila en pantalla
                $.get('scm-include/action-crono_deleteTemps.php?'+querystr, function(data){});  // esborrem la fila en BBDD
                
                $( "tr" ).each(function( index ) {
                    $(this).find('div:first').html(--index);
                });
                counter--;
            } 
        });

        var tiempo = {
            hora: 0,
            minuto: 0,
            segundo: 0
        };

        // event que recupera les dades de sortida d'un esdeveneiment ja iniciat
        $("#recovery").on('click', function(){
            <?PHP echo "addDate('datasortida','".date2SPformat($esdeveniment->datasortida, '-')."');";?>
            <?PHP echo "addTime('horasortida','".$esdeveniment->horasortida."');"?>
            <?PHP echo "iniciaRellotge('".date2SPformat($esdeveniment->datasortida, '-')."','".$esdeveniment->horasortida."',tiempo)"; ?>
              
            $("#hora").val(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
            $("#minut").val(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
            $("#segon").val(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);                
        });
        
        // event que inicia el rellotge d'un esdeveniment i guarda en bbdd la informació de data/hora de sortida


        var tiempo_corriendo = null;

        $("#start").on('click', function(){

            <?PHP echo "addDate('datasortida','');";?>
            <?PHP echo "addTime('horasortida','');"?>
                
            var horasortida = document.getElementById('horasortida').value;            
            var datasortida = document.getElementById('datasortida').value;                
            var labelsortida = document.getElementById('labelsortida');                
            
            tiempo_corriendo = setInterval(function(){
                // Segundos
                tiempo.segundo++;
                if(tiempo.segundo >= 60)
                {
                        tiempo.segundo = 0;
                        tiempo.minuto++;
                }      

                // Minutos
                if(tiempo.minuto >= 60)
                {
                    tiempo.minuto = 0;
                    tiempo.hora++;
                }

                $("#hora").val(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
                $("#minut").val(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
                $("#segon").val(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);
            }, 1000);
            
            var querystr = 'esdeveniment='+idEsdeveniment+'&datasortida='+datasortida+'&horasortida='+horasortida;
            $.get('scm-include/action-crono_updateStart.php?'+querystr, function(data) {  
               labelsortida.innerHTML = data;
            });            
        });
        
        $("#stop").on('click', function(){
                clearInterval(tiempo_corriendo);
        });
        
        $("#reset").on('click', function(){
            tiempo.hora = 0;
            tiempo.minuto = 0;
            tiempo.segundo = 0;
            $("#hora").val(tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora);
            $("#minut").val(tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto);
            $("#segon").val(tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo);            
        });        
    });
  
    function carregaParticipant(pos) {
        
        var temps = document.getElementById('temps_'+pos).innerHTML;        
        var dorsal = document.getElementById('dorsal_'+pos).value;            
        var horasortida = document.getElementById('horasortida').value;            
        var datasortida = document.getElementById('datasortida').value;                    

        var participant = document.getElementById('participant_'+pos);                        
        var localitat = document.getElementById('localitat_'+pos);                                
        var sexe = document.getElementById('sexe_'+pos);                                        
        var diploma = document.getElementById('diploma_'+pos);                                                
        
        var querystr = 'esdeveniment='+idEsdeveniment+'&control=99&dorsal='+dorsal+'&temps='+temps+'&datasortida='+datasortida+'&horasortida='+horasortida;
        $.get('scm-include/action-crono_updateTemps.php?'+querystr, function(data) {
            resultat = data.split('&&&')
            participant.innerHTML = resultat[0];                
            localitat.innerHTML = resultat[1];                            
            sexe.innerHTML = resultat[2];          
            diploma.href = "index.php?ctl=g_esdevenimentsDiploma&esdeveniment="+idEsdeveniment+"&temps="+temps+"&participant="+resultat[0];            
        });
    }
        
    function ara(tipus) {

        var d = new Date();
        
        if (tipus == 'date') {var dataString = d.getDate() + '-' + (d.getMonth() +1) + '-' + d.getFullYear();}
        if (tipus == 'time') {var dataString = d.getHours()+ ':' +d.getMinutes()+':'+d.getSeconds();}
        if (tipus == 'all') {var dataString = d.getDate() + '-' + (d.getMonth() +1) + '-' + d.getFullYear() + ', ' +d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();}
        return dataString;            
    }        

    function addDate(fieldID, dataString) {
            
        var field = document.getElementById(fieldID);  
        if (dataString == '') dataString = ara('date');
        field.value = dataString;
        field.textContent = dataString;	
    }        

    function addTime(fieldID, horaString) {
            
        var field = document.getElementById(fieldID);  
        if (horaString == '') horaString = ara('time');
        field.value = horaString;
        field.textContent = horaString;	
    }

    //
    // Funcions pel rellotge  - 08/08/2014 SCM
    //

    function iniciaRellotge(datasortida, horasortida, tiempo)    {
        
        var element_hora = document.getElementById('hora');
        var element_minut = document.getElementById('minut');    
        var element_segon = document.getElementById('segon');    

        if ((datasortida) && (horasortida)){
            // calcula la diferencia en hores, minuts i segons entre la data/hora d'inici i la data/hora actual
            var data = datasortida.split('-');            
            var hora = horasortida.split(':');
            
            var date1 = new Date(data[2],data[1]-1,data[0],hora[0],hora[1],hora[2],0); // data/hora recuperada - JavaScript counts months from 0 to 11. January is 0. December is 11.
            var date2 = new Date(); // data/hora actual           

            // Convert both dates to milliseconds & Calculate the difference in milliseconds
            var date1_ms = date1.getTime();
            var date2_ms = date2.getTime(); 
            var difference_ms = date2_ms - date1_ms;
            
            //take out milliseconds
            difference_ms = difference_ms/1000;
            segundero = Math.floor(difference_ms % 60);
            difference_ms = difference_ms/60; 
            minutero = Math.floor(difference_ms % 60);
            difference_ms = difference_ms/60; 
            horario = Math.floor(difference_ms % 24);  
            var days = Math.floor(difference_ms/24);
        }

        tiempo.segundo = segundero;
        tiempo.minuto = minutero;
        tiempo.hora = horario;
    }

    
    function tempsRellotge(){
    //obté les dades del comptador
    
        hores = document.getElementById("hora").value;
        minuts = document.getElementById("minut").value;
        segons = document.getElementById("segon").value;
        
        return hores + " : " + minuts + " : " + segons;            
    }
</script>

<form name=digital>
    <ul id="stepForm" class="ui-accordion-container">
        <fieldset>
            <div id='esdeveniment'>
                <label class="input">Data/hora d'inici:</label> 
                <?PHP print('<input class="input" id="datasortida" style="width: 80px;" type="text" name="datasortida" value="" disabled />&nbsp;-'); ?>
                <?PHP print('<input class="input" id="horasortida" style="width: 80px;" type="text" name="horasortida" value="" disabled />&nbsp;'); ?>                
                <span class="" id="labelsortida" style="width: 80px;" type="text"/>&nbsp;<br /></span>
                <label class="input">Temps de cursa:</label> 
                <input type=text id="hora" name="hora" size=2 value="00" disabled style="border:0" >&nbsp;:
                <input type=text id="minut" name="minut" size=2 value="00" disabled style="border:0" >&nbsp;:
                <input type=text id="segon" name="segon" size=2 value="00" style="border:0" disabled>&nbsp;&nbsp;

                <!-- botons de posada en marxa del crono -->
                <a  class="boto"  id="start">Inici
                    <?php echo '<img border="0" align="absmiddle" src="'.SCM_PATH_THEME.SCM_THEME.'images/time.png" class="imgnoborder">'; ?>
                </a>&nbsp;&nbsp; 
                <a  class="boto" id="stop">Congelar
                    <?php echo '<img border="0" align="absmiddle" src="'.SCM_PATH_THEME.SCM_THEME.'images/stop.png" class="imgnoborder">'; ?>
                </a>&nbsp;&nbsp;                 
                <a  class="boto" id="reset">Reset
                    <?php echo '<img border="0" align="absmiddle" src="'.SCM_PATH_THEME.SCM_THEME.'images/arrow_undo.png" class="imgnoborder">'; ?>
                </a>&nbsp;&nbsp;
            </div>
        </fieldset>    
    </ul>
</form>

<div id='taula_dades'>
    
    <table cellspacing="4" cellpadding="3" border="0" width="100%">
    <tbody>
        <tr style="text-align:right;">
            <td nowrap="" height="17" class="derecha normal" width="100%">&nbsp;</td>            
            <td nowrap="" height="17" class="derecha normal">
                <a class="boto" id="add">Marcar arribada
                    <?php echo '<img border="0" align="absmiddle" src="'.SCM_PATH_THEME.SCM_THEME.'images/award.png" class="imgnoborder">'; ?>
                </a>            
                <a class="boto" id="recovery">Recuperar dades
                    <?php echo '<img border="0" align="absmiddle" src="'.SCM_PATH_THEME.SCM_THEME.'images/arrow_refresh.png" class="imgnoborder">'; ?>
                </a>                
            </td>
        </tr>
    </tbody>
    </table>       

    <table id="dataTable" class="table table-bordered dataTable" role="grid" aria-describedby="datagrid_info">
        <thead>
            <tr role="row">
                <th  aria-label="ID" width='5%'>Posició</Th>
                <th aria-label="ID">Hora d'arribada</Th>
                <th aria-label="ID">Temps </Th>            
                <th aria-label="ID">Dorsal </Th>                        
                <th aria-label="ID" style="text-align:left;">Participant </Th>                                    
                <th aria-label="ID" style="text-align:left;">Sexe </Th>                                                
                <Th aria-label="ID" style="text-align:left;">Localitat </Th>                                    
                <th aria-label="ID"></Th>            
                <th aria-label="ID"></Th>                        
            </tr>
        </thead>
    </TABLE>
    </div>

<?php $contenido = ob_get_clean(); ?>   
<?php include APP_PATH_ABS.SCM_PATH_THEME.SCM_THEME. 'templates/gestioLayout.php'; // plantilla general de la pàgina 
