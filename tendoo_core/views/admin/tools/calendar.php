<?php echo get_core_vars( 'lmenu' );?>

<section id="content">
  <section class="vbox">
    <?php echo get_core_vars( 'inner_head' );?>
    <section class="scrollable" id="pjax-container">
      <header>
      <div class="row b-b m-l-none m-r-none">
        <div class="col-sm-4">
          <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
          <p class="block text-muted">
            <?php echo get_page('description');?>
          </p>
        </div>
      </div>
      </header>
      <section class="hbox stretch" id="taskapp">
        <aside>
        <section class="vbox">
          <header class="header bg-light lter bg-gradient b-b">
          <button class="btn btn-success btn-sm pull-right btn-icon" id="new-task"><i class="fa fa-plus"></i></button>
          <p>
            Tasks
          </p>
          </header>
          <footer class="footer b-t">
            <p class="checkbox">
              <label>
                <input id="toggle-all" type="checkbox">
                Mark all as complete</label>
            </p>
          </footer>
          <section class="bg-light lter">
            <section class="hbox stretch">
              <!-- .aside -->
              <aside>
              <section class="vbox">
                <section class="scrollable wrapper">
                  <!-- task list -->
                  <ul id="task-list" class="list-group list-group-sp">
                  </ul>
                  <!-- templates --> <script type="text/template" id="item-template"> <div class="view" id="task-<%- id %>"> <button class="destroy close hover-action">&times;</button> <div class="checkbox"> <input class="toggle" type="checkbox" <%= done ? 'checked="checked"' : '' %> /> <span class="task-name"><%- (name && name.length) ? name : 'New task' %></span> <input class="edit form-control" type="text" value="<%- name %>" /> </div> </div> </script> <!-- / template --> <!-- task list -->
                </section>
              </section>
              </aside>
              <!-- /.aside -->
            </section>
          </section>
        </section>
        </aside>
        <!-- .aside -->
        <aside class="col-lg-4 bg-white b-l">
        <section class="vbox flex" id="task-detail">
          <!-- task detail --> <script type="text/template" id="task-template"> <header class="header bg-light lt b-b"> <p class="m-b"> <span class="text-muted">Created:</span> <%- moment(date).format('MMM Do, h:mm a') %> </p> <div class="lter pull-in b-t m-t-xxs"> <textarea type="text" class="form-control form-control-trans scrollable" placeholder="Task description"><%- desc %></textarea> </div> </header> <section> <section> <section> <ul id="task-comment" class="list-group no-radius no-border m-t-n-xxs"> </ul> </section> </section> </section> <footer class="footer bg-light lter clearfix b-t"> <div class="input-group m-t-sm"> <input type="text" class="form-control input-sm" id="task-c-input" placeholder="Type a comment"> <span class="input-group-btn"> <button class="btn btn-success btn-sm" type="button" id="task-c-btn"><i class="fa fa-pencil"></i></button> </span> </div> </footer> </script> <!-- task detail --> <script type="text/template" id="item-c-template"> <div class="view"> <button class="destroy close hover-action">&times;</button> <div> <span><%- desc %></span> <small class="text-muted block text-xs"><i class="fa fa-time"></i> <%- moment(date).fromNow() %></small> </div> </div> </script>
        </section>
        </aside>
        <!-- /.aside -->
      </section>
    </section>
  </section>
</section>
