<template>
  <div class="list-room">
    <div class="row">
      <div class="col-6">
        <update-room v-if="isUnactive === false" :id="this.id"/>
      </div>

      <div class="col-6">
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th colspan="2">Danh sách phòng họp</th>
            </tr>
          </thead>
          <tbody>
            <tr colspan="2" v-for="(room, index) in listRoom" :key="room.id"
              :id="index"
            >
              <td><router-link :to="{ name: 'room' , params: { id: room.id} }" >{{room.name}}</router-link></td>

              <td>
                  <button class='btn btn-primary' @click="editRoom(room.id)"><font-awesome-icon :icon="['fas', 'edit']" /></button>
                  
                  <button class='btn btn-danger' @click="removeRoom(room.id)"><font-awesome-icon :icon="['fas', 'trash']" /></button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>

  import UpdateRoom from './UpdateRoom'

  export default {
    components:{
      UpdateRoom
    },

    data(){
      return {
        listRoom: [],
        id: '',

        flag: 1,
        isUnactive: true
      }
    },

    created(){
      axios.get('/phonghop')
      .then(response => {
        console.log(response.data.groups)
        this.listRoom = response.data.groups
      })
      .catch(error => {
        console.log(error)
      })
    },

    methods: {
      removeRoom(roomId){
        axios.put(`/phonghop/${roomId}`)
        .then(response => {
          console.log(response.data.message);

          let room = this.listRoom.find(room => room.id === roomId)

          let index = this.listRoom.indexOf(room)

          this.listRoom.splice(index, 1)
        })
        .catch(error => {
          console.log(error)
        })
      },

      editRoom(roomId){
        this.flag += 1

        if (this.flag % 2 === 0){
          this.isUnactive = false

          this.id = roomId
        }else{
          this.isUnactive = true
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .list-room{
    border: 1px solid #ccc;
  }

  .table{
    margin-top: 5px;
    border: 1px solid #ccc;
  }
  
  .table .thead-dark th, td{
    text-align: center;
  }
</style>