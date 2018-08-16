<template>
     <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" v-text="notifications.length"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Tu tienes {{notifications.length}} notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li v-for="noti in notifications">
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i>{{noti.user.usuario}} {{noti.mensaje}} en {{noti.idextraclase}}
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
</template>
<script>
    export default {
      data(){
            return{
              notifications:[]
            }
        },
        props:['iduser'],
        methods:{

        },
        mounted() {
          Echo.private('notification')
            .listen('Notification', (e) => {
              if(e.user.id!=this.iduser){
                this.notifications.push(e);
                var audio = new Audio('/archivos/sounds/notification.mp3');
                audio.play();
                
              }
            });

            
        }
    };
</script>
