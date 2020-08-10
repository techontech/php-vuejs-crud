<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap/dist/css/bootstrap.min.css" />
    <!-- BootstrapVue CSS -->
    <link type="text/css" rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />

    <title>PHP OOP VUEJS CRUD</title>

    <style>
      [v-cloak] {
        display: none;
      }
    </style>

  </head>
  <body>
    <div class="container" id="app" v-cloak>
      <div class="row">
        <div class="col-md-12 mt-5">
          <h1 class="text-center">PHP OOP VUEJS CRUD</h1>
          <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">

          <!-- Add Records -->
          <div>
            <b-button id="show-btn" @click="showModal('my-modal')">Add Records</b-button>

            <b-modal ref="my-modal" hide-footer title="Add Records">
              <div>
                <form action="" @submit.prevent="onSubmit">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" v-model="name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" v-model="email" class="form-control">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-sm btn-outline-info">Add Records</button>
                  </div>
                </form>
              </div>
              <b-button class="mt-3" variant="outline-danger" block @click="hideModal('my-modal')">Close Me</b-button>
            </b-modal>
          </div>

          <!-- Update Record -->
          <div>
            <b-modal ref="my-modal1" hide-footer title="Update Record">
              <div>
                <form action="" @submit.prevent="onUpdate">
                  <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" v-model="edit_name" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" v-model="edit_email" class="form-control">
                  </div>
                  <div class="form-group">
                    <button class="btn btn-sm btn-outline-info">Update Record</button>
                  </div>
                </form>
              </div>
              <b-button class="mt-3" variant="outline-danger" block @click="hideModal('my-modal1')">Close Me</b-button>
            </b-modal>
          </div>
        </div>
      </div>
      <div class="row" v-if="records.length">
        <div class="col-md-12">
          <table class="table table-borderless">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(record, i) in records" :key="record.id">
                <td>{{i + 1}}</td>
                <td>{{record.name}}</td>
                <td>{{record.email}}</td>
                <td>
                  <button @click="deleteRecord(record.id)" class="btn btn-sm btn-outline-danger">Delete</button>
                  <button @click="editRecord(record.id)" class="btn btn-sm btn-outline-info">Edit</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Vuejs -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <!-- BootstrapVue js -->
    <script src="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
      var app = new Vue({
        el: '#app',
        data: {
          name: '',
          email: '',
          records: [],
          edit_id: '',
          edit_name: '',
          edit_email: ''
        },

        methods: {
          showModal(id) {
            this.$refs[id].show()
          },
          hideModal(id) {
            this.$refs[id].hide()
          },

          onSubmit(){
            if (this.name !== '' && this.email !== '') {
              var fd = new FormData()

              fd.append('name', this.name)
              fd.append('email', this.email)

              axios({
                url: 'insert.php',
                method: 'post',
                data: fd
              })
              .then(res => {
                // console.log(res)
                if (res.data.res == 'success') {
                  alert('record added')
                  this.name = ''
                  this.email = ''

                  app.hideModal('my-modal')
                  app.getRecords()
                }else{
                  alert('error')
                }
              })
              .catch(err => {
                console.log(err)
              })
            }else{
              alert('empty')
            }
          },

          getRecords(){
            axios({
              url: 'records.php',
              method: 'get'
            })
            .then(res => {
              // console.log(res)
              this.records = res.data.rows
            })
            .catch(err => {
              console.log(err)
            })
          },

          deleteRecord(id){
            if (window.confirm('Delete this record')) {
              var fd = new FormData()

              fd.append('id', id)

              axios({
                url: 'delete.php',
                method: 'post',
                data: fd
              })
              .then(res => {
                // console.log(res)
                if (res.data.res == 'success') {
                  alert('delete successfully')
                  app.getRecords();
                }else{
                  alert('error')
                }
              })
              .catch(err => {
                console.log(err)
              })
            }
          },

          editRecord(id){
            var fd = new FormData()

            fd.append('id', id)

            axios({
              url: 'edit.php',
              method: 'post',
              data: fd
            })
            .then(res => {
              if (res.data.res == 'success') {
                this.edit_id = res.data.row[0]
                this.edit_name = res.data.row[1]
                this.edit_email = res.data.row[2]
                app.showModal('my-modal1')
              }
            })
            .catch(err => {
              console.log(err)
            })
          },

          onUpdate(){
            if (this.edit_name !== '' && this.edit_email !== '' && this.edit_id !== '') {

              var fd = new FormData()

              fd.append('id', this.edit_id)
              fd.append('name', this.edit_name)
              fd.append('email', this.edit_email)

              axios({
                url: 'update.php',
                method: 'post',
                data: fd
              })
              .then(res => {
                // console.log(res)
                if (res.data.res == 'success') {
                  alert('record update');

                  this.edit_name = '';
                  this.edit_email = '';
                  this.edit_id = '';

                  app.hideModal('my-modal1');
                  app.getRecords();
                }
              })
              .catch(err => {
                console.log(err)
              })

            }else{
              alert('empty')
            }
          }

        },

        mounted: function(){
          this.getRecords()
        }
      })

    </script>
</html>