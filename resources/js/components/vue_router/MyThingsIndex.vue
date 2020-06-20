<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createCompany'}" class="btn btn-success">Create new things</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">things list</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>tag</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="things, index in things_shape_a_lifestyles">
                        <td>{{ things.name }}</td>
                        <td>
                            <router-link :to="{name: 'editCompany', params: {id: things.id}}" class="btn btn-xs btn-default">
                                Edit
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(things.id, index)">
                                Delete
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                things_shape_a_lifestyles: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/things_shape_a_lifestyles')
                .then(function (resp) {
                    app.things_shape_a_lifestyles = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load companies");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/things_shape_a_lifestyles/' + id)
                        .then(function (resp) {
                            app.things_shape_a_lifestyles.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete company");
                        });
                }
            }
        }
    }
</script>
