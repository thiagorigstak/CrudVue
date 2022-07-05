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
                        application.myModel = false;
                        application.fetchUsers();
                        application.user = '';
                        application.email = '';
                        application.telefone = '';
                        alert(response.data.message);
                    });
                }
                if (application.actionButton == 'Update') {
                    axios.post('actions.php', {

                    })
                }
            }
        },
    },
})