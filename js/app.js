var application = new Vue({
    el: '#Vueapp',
    data: {
        users: '',
        myModal: false,
        errorMessage: '',
        successMessage: '',
        actionButton: 'Adicionar',
        DynamicTitle: 'Adicionar Usuario',
    },
    methods: {
        fetchUsers: function () {
            axios.post('actions.php', {
                action: 'fetchusers'
            }).then(function (response) {
                application.users = response.data;
            });
        },
        openModal: function () {
            application.user = '';
            application.email = '';
            application.telefone = '';
            application.id = '';
            application.actionButton = 'Adicionar';
            application.DynamicTitle = 'Adicionar Usuario';
            application.myModal = true;
        },
        submitData: function () {
            if (application.user != '' && application.email != '' && application.telefone != '') {
                if (application.actionButton == 'Adicionar') {
                    axios.post('actions.php', {
                        action: 'insert',
                        user: application.user,
                        email: application.email,
                        telefone: application.telefone,
                    }).then(function (response) {
                        application.myModal = false;
                        application.fetchUsers();
                        application.user = '';
                        application.email = '';
                        application.telefone = '';
                        alert(response.data.message);
                    });
                }
                if (application.actionButton == 'Update') {
                    axios.post('actions.php', {
                        action: 'update',
                        user: application.user,
                        email: application.email,
                        telefone: application.telefone,
                        id: application.id
                    }).then(function (response) {
                        console.log(response);
                        application.myModal = false;
                        application.fetchUsers();
                        application.user = '';
                        application.email = '';
                        application.telefone = '';
                        application.id = '';
                        alert("UPDATE " + response.data.message);
                    });
                }
            } else {
                alert("Preencha todos os campos");
            }
        },
        fetchUser: function (id) {
            axios.post('actions.php', {
                action: 'fetchSingle',
                id: id
            }).then(function (response) {
                //console.log(response);
                application.user = response.data.nome;
                application.email = response.data.email;
                application.telefone = response.data.telefone;
                application.id = response.data.id;
                application.myModal = true;
                application.actionButton = 'Update';
                application.DynamicTitle = 'Editar Usuario #' + application.id;
                //alert(response.data.id);
            });
        },
        deleteUser: function (id) {
            if (confirm("Você realmente deseja excluir este usuario?")) {
                axios.post('actions.php', {
                    action: 'delete',
                    id: id
                }).then(function (response) {
                    application.fetchUsers();
                    alert(response.data.message);
                });
            }
        }
    },
    created: function () {
        this.fetchUsers();
    }
})