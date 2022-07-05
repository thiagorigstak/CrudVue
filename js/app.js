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
                        telefone: application.email,
                        hiddenId: application.hiddenId
                    }).then(function (response){
                        application.myModal = false;
                        application.fetchUsers();
                        application.user = '';
                        application.email='';
                        application.telefone='';
                        application.hiddenId='';
                        alert(response.data.message);
                    });
                }
            } else {
                alert("fill all fields");
            }
        },
        fetchUser:function(id){
            axios.post('action.php', {
                action: 'fetchSingle',
                id: id
            }).then(function(response){
                application.user = response.data.user;
                application.email = response.data.email;
                application.telefone = response.data.telefone;
                application.hiddenId = response.data.id;
                application.myModal = false;
                application.actionButton = 'Update';
                application.DynamicTitle = 'Editar Usuario';                
            });
        },
        deleteUser:function(id){
            if(confirm("Você realmente deseja excluir este usuario?")){
                axios.post('action.php', {
                    action: 'delete',
                    id: id
                }).then(function(response){
                    application.fetchUsers();
                    alert(response.data.message);
                });
            }
        }
    },
    created: function(){
        this.fetchUsers();
    }
})