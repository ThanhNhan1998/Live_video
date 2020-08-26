<template>
    <div>
        <div class="row">
            <div class="col-5 room">
                <h1 style="color: blue">{{room.name}}</h1>
                <table class="table table-striped table-inverse table-responsive">
                    <thead class="thead-inverse">
                        <tr>
                            <th>#</th>
                            <th>Members</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(member, index) in memberLists" :key="member.id">
                                <td>{{index + 1}}</td>

                                <td scope="row">
                                    
                                    {{member.name}}
                                    <font-awesome-icon style="color: red" :icon="['fas', 'user']" v-if="member.id === currentUser.id"/>
                                </td>

                                <td v-if="member.id != currentUser.id">
                                    <button @click="startVideoChat(member.id)" data-toggle="modal">
                                        <font-awesome-icon :icon="['fas', 'camera']" />
                                    </button>

                                    <button @click="Remove(member.id)">
                                        <font-awesome-icon :icon="['fas', 'trash']" />
                                    </button>
                                </td>
                            </tr>

                            <tr colspan="3">
                                <td style="background-color: #FFF">
                                    <button type="button" 
                                        class="btn btn-primary" 
                                        data-toggle="modal" 
                                        data-target="#myModal"
                                        @click="getUserNotInRoom">
                                        
                                        Invite
                                    </button>
                                </td>

                                <td style="background-color: #FFF">
                                    <button type="button" 
                                        class="btn btn-success" 
                                        @click="CallAll">
                                        
                                        Call All
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                </table>

                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Invite User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <table class="table table-striped table-inverse table-responsive">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(user, index) in userNotInRoom" :key="user.id">
                                            <td>{{index + 1}}</td>
                                            <td>{{user.name}}</td>
                                            <td>
                                                <span class="btn btn-primary" @click="invite(user.id)">
                                                    <font-awesome-icon :icon="['fas', 'user-plus']" />
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                            </table>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                    </div>
                    </div>
                </div>

                <div class="modal fade" id="videoCallScreen">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                        <h4 class="modal-title">Video Call</h4>
                        
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div>
                                <table>
                                    <tr>
                                        <!-- <td><video autoplay id="localVideo" ref="localVideo"></video></td>
                                        <td><video autoplay id="remoteVideo" ref="remoteVideo"></video></td> -->

                                        <td>
                                            <div class="video-container" ref="video-container">
                                                <video id="localVideo" class="localVideo" ref="localVideo" autoplay></video>  
                                                <video id="remoteVideo" class="remoteVideo" ref="remoteVideo" autoplay></video>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="closeVideo">
                            <font-awesome-icon :icon="['fas', 'phone']" />
                        </button>
                        </div>
                        
                    </div>
                    </div>
                </div>

                
                <!-- <div class="modal fade" id="Calling">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    
                        
                        <div class="modal-header">
                        <h4 class="modal-title">Video Call</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                      
                        <div class="modal-body">
                            <div>
                                <table>
                                    <tr>
                                        <td><button type="button" class="btn btn-success" @click="this.accepted = true">Accepted</button></td>
                                        <td><button type="button" class="btn btn-danger">Denied</button></td>
                                    </tr>
                                </table>

                                
                                
                            </div>
                        </div>
                        
                        
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        
                    </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
    import Pusher from 'pusher-js';
    import Peer from 'simple-peer';
    // const mediaStreamConstraints = {
    //     video: true, 
    //     audio: false
    // }

    // const hdConstraints = {
    //     video: {
    //         width: {
    //             min: 1280
    //         },
    //         height: {
    //             min: 720
    //         }
    //     },
    // }   

    // let localStream
    // let localPeerConnection


    // localPeerConnection.addEventListener(
    //     'iceconnectionstatechange', handleConnectionChange
    // )

    // function gotLocalMediaStream(mediaStream){
    //     let localVideo = document.getElementById("localVideo")
    //     let remoteVideo = document.getElementById("remoteVideo")

    //     localStream = mediaStream
    //     localVideo.srcObject = mediaStream
    //     remoteVideo.srcObject = mediaStream
    // }

    // function handleLocalMediaStreamError(error){
    //     console.log('navigator.getUserMedia error: ', error)
    // }


export default {
    
    data(){
        return {
            currentUser:{
                type:Object
            },

            room: {
                type: Object
            },

            memberLists: [],

            userNotInRoom: [],

            pusherKey: 'a6b03ac52ddf00703213',

            pusherCluster: 'ap3',

            channel: null,
            stream: null,
            peers: {},

            user_id: null,

            remoteStream: null,

            accepted: false
        }
    },
    
    created(){
        this.getCurrentUser()

        this.getRoomList()
    },

    mounted() {
        this.setupVideoChat();
    },
    
    methods:{

        getCurrentUser(){
            axios.get('/phonghop/currentUser')
            .then(response => {
                console.log(response.data.currentUser)
                this.currentUser = response.data.currentUser
            })
            .catch(error => {
                console.log(error)
            })
        },

        getRoomList(){
            axios.get(`/phonghop/${this.$route.params.id}`)
            .then(response => {
                this.room = response.data.group
                this.memberLists = response.data.group_users
            })
            .catch(error => {
                console.log(error)
            })
        },

        getUserNotInRoom(){
            axios.get(`/phonghop/${this.room.id}/userNotInRoom`)
            .then(response => {
                console.log(response.data.userNotInRoom)
                this.userNotInRoom = response.data.userNotInRoom
            })
            .catch(error => {
                console.log(error)
            })
        },

        invite(userId){

            axios.post(`/phonghop/${this.room.id}/invite`, {user_id: userId})
            .then(response => {
                console.log(response.data.message)

                let user = this.userNotInRoom.find(user => user.id === userId)

                this.memberLists.push(user)
            })
            .catch(error => {
                console.log(error)
            })   
        },

        Remove(memberId){
            axios.get(`/phonghop/${this.room.id}/remove/${memberId}`)
            .then(response => {
                let member = this.memberLists.find(member => member.id === memberId)

                this.memberLists.splice(this.memberLists.indexOf(member), 1)
            })
            .catch(error => {
                console.log(error)
            })
        },

        // Call(userId){
        //     this.user_id = userId;
        //     $('#Calling').modal();
        // },

        startVideoChat(userId) {

            this.user_id = userId
        
            const localVideo = this.$refs['localVideo'];

            localVideo.srcObject = this.stream;

            this.getPeer(userId, true);

            $('#videoCallScreen').modal({
                backdrop: 'static'
            });
        },

        getPeer(userId, initiator) {
            if(this.peers[userId] === undefined) {
                let peer = new Peer({
                    initiator,
                    stream: this.stream,
                    trickle: false
                });

                peer.on('signal', (data) => {

                    this.channel.trigger(`client-signal-${userId}`, {
                        userId: this.currentUser.id,
                        data: data,
                        userRemote: userId
                    });
                })
                .on('close', () => {
                    const peer = this.peers[userId];
                    if(peer !== undefined) {
                        peer.destroy();
                    }

                    delete this.peers[userId];
                });

                this.peers[userId] = peer;
            } 

            return this.peers[userId];
        },

        async setupVideoChat() {
            
            const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });

            this.stream = stream;

            const pusher = this.getPusherInstance();

            this.channel = pusher.subscribe('presence-video-chat');

            this.channel.bind(`client-signal-${this.currentUser.id}`, (signal) => 
            {
                const peer = this.getPeer(signal.userId, false);

                peer.on('stream', (stream) => {
                    
                    const remoteVideo = this.$refs['remoteVideo'];
                    remoteVideo.srcObject = stream;

                    const localVideo = this.$refs['localVideo'];

                    localVideo.srcObject = this.stream;

                    $('#videoCallScreen').modal({
                        backdrop: 'static'
                    });
                })

                peer.signal(signal.data);
            });
        },

        getPusherInstance() {
            return new Pusher(this.pusherKey, {
                authEndpoint: '/phonghop/auth/video_chat',

                cluster: this.pusherCluster,

                auth: {
                    headers: {
                        'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
                    }
                }
            });
        },

        closeVideo(){
            const peer = this.peers[this.user_id];

            if(peer !== undefined) {
                peer.destroy();
            }

            delete this.peers[this.user_id];
        },

        CallAll(){
            const localVideo = this.$refs['localVideo'];

            localVideo.srcObject = this.stream;
            
            this.memberLists.forEach(element => {
                this.getPeer(element.id, true);
            });

            $('#videoCallScreen').modal({
                backdrop: 'static'
            });
        }
    }
}
</script>

<style scoped>
    .room{
        border: 1px solid #ccc
    }

    /* #localVideo{
        max-width: 100%;

        
    }

    #remoteVideo{
        max-width: 100%;

       
    } */

    .video-container {
  width: 450px;
  height: 380px;
  margin: 8px auto;
  border: 3px solid #000;
  position: relative;
  box-shadow: 1px 1px 1px #9e9e9e;
}
.localVideo {
  width: 130px;
  position: absolute;
  left: 10px;
  bottom: 16px;
  border: 1px solid #000;
  border-radius: 2px;
  z-index: 2;
}
.remoteVideo {
  width: 100%;
  height: 380px;
  z-index: 1;
}
</style>