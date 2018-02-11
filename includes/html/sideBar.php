<!-- **********************************************************************************************************************************************************
MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
        
        	  <p class="centered">
                <a href="profile.php"><img src="<?php echo$user_data['foto']?>" class="img-circle" width="60"></a></p>                                              
        	  <h5 class="centered"><?php echo $user_data['nombre']." ".$user_data['apellidoP']." ".$user_data['apellidoM'];?></h5>
        	<?php
                if ($user_data['idtipoUsuario'] === '2' || $user_data['idtipoUsuario'] === '1') {?>
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-calendar"></i>
                            <span>Calendarios</span>
                        </a>
                        <ul class="sub">
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar"></i>
                                    <span>Consumo</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="calendarCelula.php?var=0">Consumo</a></li>
                                    <?php
                                        $result = usersBAMFConsumoD();
                                        while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <li><a  href="calendar.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        $result = usersBAMFConsumoP();
                                        while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <li><a  href="calendar.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar"></i>
                                    <span>Corporativo</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="calendarCelula.php?var=1">Corporativo</a></li>
                                    <?php
                                        $result = usersBAMFCoorporativoD();
                                        while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <li><a  href="calendar.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        $result = usersBAMFCoorporativoP();
                                        while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <li><a  href="calendar.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        </ul>                        
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-users"></i>
                            <span>Usuarios</span>
                        </a>
                        <ul class="sub">
                            <li><a  href="registerUser.php">Registro de Usuario</a></li>
                            <li><a  href="userList.php">Lista de usuarios</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-pencil-square-o"></i>
                            <span>Proyectos</span>
                        </a>
                        <ul class="sub">
                            <li><a  href="registerProject.php">Registro de Proyecto</a></li>
                            <li><a  href="proyectListActivos.php">Proyectos Activos</a></li>
                            <li><a  href="proyectListNoActivos.php">Proyectos No Activos</a></li>
                            <li><a  href="proyectListSuspendidos.php">Proyectos Suspendidos</a></li>
                            <li><a  href="proyectListEntregados.php">Proyectos Entregados</a></li>
                            <li><a  href="listaProyectos.php">Lista de Proyectos</a></li>
                        </ul>
                    </li>     
                    <li>
                        <a href="clientes.php">
                            <i class="fa fa-smile-o"></i>
                            <span>Clientes</span>
                        </a>
                    </li>               
            <?php        
                }elseif ($user_data['idtipoUsuario'] === '3' || $user_data['idtipoUsuario'] === '5') {?>
                    <li class="mt">
                        <a href="myCalendar.php">
                            <i class="fa fa-calendar"></i>
                            <span>Calendario</span>
                        </a>
                    </li>
            <?php
                }if ($user_data['correoElectronico'] === 'k.garcia@bamf.com.mx') {?>
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-calendar"></i>
                            <span>Calendarios</span>
                        </a>
                        <ul class="sub">
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar-check-o"></i>
                                    <span>Corporativo</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="calendarCelulaLider.php?var=1">Corporativo</a></li>
                                    <?php
                                        $result = usersBAMFCoorporativoD();
                                        while ($row = mysql_fetch_array($result)) {
                                            if ($row['correoElectronico'] === 'k.garcia@bamf.com.mx') {
                                                echo "";
                                            }else{?>
                                                <li><a  href="calendarLider.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php                                                
                                            }                                    
                                        }
                                    ?>
                                    <?php
                                        $result = usersBAMFCoorporativoP();
                                        while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <li><a  href="calendarLider.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        </ul>                        
                    </li>
                    <li class="mt">
                        <a href="listaProyectosLider.php">
                            <i class="fa fa-pencil-square-o"></i>
                            <span>Lista de Proyectos</span>
                        </a>
                    </li>
            <?php
                }if ($user_data['correoElectronico'] === 'j.galvan@bamf.com.mx') {?>
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-calendar"></i>
                            <span>Calendarios</span>
                        </a>
                        <ul class="sub">
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar"></i>
                                    <span>Consumo</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="calendarCelulaLider.php?var=0">Consumo</a></li>
                                    <?php
                                        $result = usersBAMFConsumoD();
                                        while ($row = mysql_fetch_array($result)) {
                                            if ($row['correoElectronico'] === 'j.galvan@bamf.com.mx') {
                                                echo "";
                                            }else{?>
                                                <li><a  href="calendarLider.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php                                                
                                            }
                                        }
                                    ?>
                                    <?php
                                        $result = usersBAMFConsumoP();
                                        while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <li><a  href="calendarLider.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        </ul>                        
                    </li>
                    <li class="mt">
                        <a href="listaProyectosLider.php">
                            <i class="fa fa-pencil-square-o"></i>
                            <span>Lista de Proyectos</span>
                        </a>
                    </li>
            <?php
                }if ($user_data['correoElectronico'] === 'p.esparza@bamf.com.mx') {?>
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-calendar"></i>
                            <span>Calendarios</span>
                        </a>
                        <ul class="sub">
                            <li class="sub-menu">
                                <a href="javascript:;" >
                                    <i class="fa fa-calendar-check-o"></i>
                                    <span>Corporativo</span>
                                </a>
                                <ul class="sub">
                                    <li><a href="calendarCelulaLider.php?var=1">Corporativo</a></li>
                                    <?php
                                        $result = usersBAMFCoorporativoD();
                                        while ($row = mysql_fetch_array($result)) {
                                            if ($row['correoElectronico'] === 'p.esparza@bamf.com.mx') {
                                                echo "";
                                            }else{?>
                                                <li><a  href="calendarLider.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php                                                
                                            }                                    
                                        }
                                    ?>
                                    <?php
                                        $result = usersBAMFCoorporativoP();
                                        while ($row = mysql_fetch_array($result)) {
                                    ?>
                                    <li><a  href="calendarLider.php?var=<?=$row['correoElectronico']?>"><?=$row['nombre']?> <?=$row['apellidoP']?> <?=$row['apellidoM']?></a></li>
                                    <?php
                                        }
                                    ?>
                                </ul>
                            </li>
                        </ul>                        
                    </li>
                    <li class="mt">
                        <a href="listaProyectosLider.php">
                            <i class="fa fa-pencil-square-o"></i>
                            <span>Lista de Proyectos</span>
                        </a>
                    </li>
            <?php
                }
            ?>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end