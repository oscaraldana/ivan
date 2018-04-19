<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$cliente = new cliente();
$cliente->consultarReferidos();

?>
<link rel="stylesheet" href="../client/css/hierarchy-view.css">
<link rel="stylesheet" href="../client/css/main.css">
<style>body{ background-color: #303840 }</style>
<!--Management Hierarchy-->
    <section class="management-hierarchy">
        
        <h1> Mis Referidos</h1>
        
        <div class="hv-container">
            <div class="hv-wrapper">
<?php
                
                $cliente->imprimirReferidos();
                
                echo $cliente->imprimirMisRef;
                
                ?>
                                
            </div>
        </div>
        
        
        <!--
        <div class="hv-container">
            <div class="hv-wrapper">

                
                
                <div class="hv-item">

                    <div class="hv-item-parent" title="dddddddd d d ">
                        <div class="person"  data-toggle="tooltip" title="loquesea">
                            <img src="https://randomuser.me/api/portraits/men/62.jpg" alt="xxxxx" data-toggle="tooltip" title="loquesea"> 
                            <p class="name">
                                Este soy yo!
                            </p>
                        </div>
                    </div>

                    <div class="hv-item-children">

                        <div class="hv-item-child">
                            
                            
                            <div class="hv-item">

                                <div class="hv-item-parent">
                                    <div class="person">
                                        <img src="https://randomuser.me/api/portraits/women/50.jpg" alt="">
                                        <p class="name">Una Hija</p>
                                    </div>
                                </div>

                                <div class="hv-item-children">

                                    <div class="hv-item-child">
                                        <div class="person">
                                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="">
                                            <p class="name">Una Nieta</p>
                                        </div>
                                    </div>


                                    <div class="hv-item-child">
                                        <div class="person">
                                            <img src="https://randomuser.me/api/portraits/men/81.jpg" alt="">
                                            <p class="name">Un Nieto</p>
                                        </div>
                                    </div>

                                    <div class="hv-item-child">
                                        <div class="person">
                                            <img src="https://randomuser.me/api/portraits/women/18.jpg" alt="">
                                            <p class="name">Otra Nieta </p>
                                        </div>
                                    </div>
                                    <div class="hv-item-child">
                                        <div class="person">
                                            <img src="https://randomuser.me/api/portraits/women/11.jpg" alt="">
                                            <p class="name">Ooootra nieta</p>
                                        </div>
                                    </div>
                                    
                                    
                                    

                                </div>

                            </div>
                        </div>


                        <div class="hv-item-child">
                            
                            
                            <div class="hv-item">

                                <div class="hv-item-parent">
                                    <div class="person">
                                        <img src="https://randomuser.me/api/portraits/men/3.jpg" alt="">
                                        <p class="name">Un hijo</p>
                                    </div>
                                </div>

                                <div class="hv-item-children">

                                    <div class="hv-item-child">
                                        <div class="person">
                                            <img src="https://randomuser.me/api/portraits/men/41.jpg" alt="">
                                            <p class="name">Un nieto</p>
                                        </div>
                                    </div>


                                    <div class="hv-item-child">
                                        <div class="person">
                                            <img src="https://randomuser.me/api/portraits/men/90.jpg" alt="">
                                            <p class="name">Otro Nieto</p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
-->        
        
    </section>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>