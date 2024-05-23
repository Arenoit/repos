<?php
    require_once('../database/dashboard.php');
    require_once('./microhead.php');
    require_once('../database/showsolicitude.php');//el orden del archivo influye en el session_start
?>
            <style>
                :is(.table-striped tbody tr) td:nth-child(2),td:nth-child(3) {
                    text-align: center;
                    padding: 0 15px 0 15px;
                }
                @media (max-width: 500px){
                    .sidebar.active ~ .home-section .home-content{
                        width: 100%;
                        overflow-x: scroll;
                        margin-bottom: 30px;
                    }
                }
                @media (max-width: 400px){
                    .home-section{
                        left: -25px;
                    }
                    .account-header{
                        width: 20rem;
                    }
                }
            </style>
            <div class="home-content">
                <div class="overview-boxes">
                    <div class="container">
                        <br><br>
                        <div class="account-header">Solicitud de subida de archivos</div>
                        <br>
                        <form action="./solicitude" method="POST">
                            <input class="btn btn-success" type="submit" value="Realizar una solicitud">
                            <a class="btn btn-request" href="./solicitude?admit=edit">Editar solicitudes</a>
                        </form>
                        <br>
                        <div class="account-header">Solicitudes realizadas</div>
                        <br>
                        <table class="table-striped table-bordered dataTable no-footer" style="width: 100%;">
                            <thead class="sorting">
                            <tr role="row"><th tabindex="0" style="width:66px;height:30px">Índice</th>
                            <th tabindex="0" rowspan="1" colspan="1" style="width:250px;">Titulo</th>
                            <th tabindex="0" rowspan="1" colspan="1" style="width:185px;">Materia / ubicación</th>
                            <th tabindex="0" rowspan="1" colspan="1" style="width:80px;">Revisado</th>
                            </thead>
                            <tbody>
                                <?php 
                                $i=1;
                                foreach($solicitude as $edits){
                                    $rev=($edits['solic_rev_solic']==0)?"SIN REVISAR":"REVISADO";
                                ?>
                                    <tr>
                                        <td><?=$i;?></td>
                                        <td><?=$edits['solic_prj_solic'];?></td>
                                        <td><?=$edits['solic_ubi_solic'];?></td>
                                        <td><?=$rev;?></td>
                                    </tr>
                                <?php 
                                $i++;}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <script src="../js/coders.js"></script>
    </body>
</html>