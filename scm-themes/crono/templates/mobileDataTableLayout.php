<!--DataTables -->
<link rel="stylesheet" href="<?php echo APP_PATH.APP_PATH_THEME.APP_THEME ?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

<!-- Main content -->
            <div class="box-body">
                <div id="" class="dataTables_wrapper form-inline dt-bootstrap ">
                    <form id="datagrid_form" method="post" action="<?PHP echo $_SERVER['REQUEST_URI']; ?>">
                        <?PHP echo $datagrid->renderSearchTable(); ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="datagrid" data-role="table" data-mode="reflow" class="ui-body-d ui-shadow table-stripe ui-responsive">                                                                   
                                    <thead>
                                        <tr role="row">
                                            <?PHP echo $datagrid->renderHeaderTable(); ?>
                                        </tr>                        
                                    </thead>                            
                                    <tbody>
                                        <?PHP echo $datagrid->renderDatatable(); ?>
                                    </tbody>
                                </table>    
                            </div>
                        </div>     
                        <div class="row">
                            <input type="hidden" id="__np" name="__np" value="" />
                            <div class="col-sm-5">
                                <div class="dataTables_info" id="info" role="status" aria-live="polite"><?PHP echo $datagrid->renderNavigationTable('total'); ?></div>
                            </div>                            
                            <div class="col-sm-7">
                                <div class="dataTables_paginate paging_simple_numbers">                                
                                    <?PHP echo $datagrid->renderNavigationTable('navigate'); ?>  
                                </div>
                            </div>   
                        </div>
                    </form>    
                </div>
            </div>


