<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Crud utilizando VUE</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
    <div id="Vueapp">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand"><img src="img/logo.png" alt="" class="logo-custom" />ue</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="">Home<span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <button class="btn btn-success btn-xs" @click="openModal()" value="add">Adicionar Usuario</button>
                </li>
            </ul>
        </nav>


        <div class="container p-5">
            <div class="row">
                <div class="alert alert-danger col-md-6" id="alertMessage" role="alert" v-if="errorMessage">
                    {{ errorMessage }}
                </div>
                <div class="alert alert-success col-md-6" id="alertMessage" role="alert" v-if="successMessage">
                    {{ successMessage }}
                </div>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Id</th>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody class="tbody-custom">
                        <tr v-for="user in users">
                            <td>{{user.id}}</td>
                            <td>{{user.user}}</td>
                            <td>{{user.email}}</td>
                            <td>{{user.telefone}}</td>
                            <td><button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchUser(row.id)">Edit</button></td>
                            <td><button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteUser(row.id)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if='myModal'>
            <transition name="modal">
                <div class="modal col-md-6">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ DynamicTitle }}</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" @click="myModal=false" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Insira Usuario</label>
                                <input type="text" class="form-control" v-model="user" />
                            </div>
                            <div class="form-group">
                                <label>Insira Email</label>
                                <input type="email" class="form-control" v-model="email" />
                            </div>
                            <div class="form-group">
                                <label>Insira Telefone</label>
                                <input type="text" class="form-control" v-model="telefone" />
                            </div>
                            <div align="center">
                                <input type="hidden" v-model="hiddenId" />

                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-success btn-xs" v-model="actionButton" @click="submitData" />
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</body>

</html>
<!-- <script src="https://unpkg.com/vue@3"></script> -->
<script type="module" src="js/app.js"></script>