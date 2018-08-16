<template>
    <div>
        <div class="row" id="app">
            <div class="col-md-12">
                <ul class="list-group">
                    <li class="list-group-item active">Chat</li>
                    <ul class="list-group" v-for="m in chat.message" :key="m">
                        <li class="list-group-item" v-text="m"></li>
                    </ul>
                    <input type="text" class="form-control" placeholder="Ingrese su mensaje" v-model="message" @keyup.enter="send">
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
      message:'',
      chat:{
        message:[],
      }
    };
  },
  methods: {
    send(){
        let me=this;
        if (this.message.length != 0) {
        axios.post("/send", {
          message:this.message
        })
        .then(function(response) {
          console.log(response);
          me.message='';
        })
        .catch(function(error) {
          console.log(error);
        });
        }
    }

  },
  mounted() {
    Echo.private('chat')
    .listen('ChatEvent', (e) => {
        this.chat.message.push(e.message);
    });
  }
}
</script>
