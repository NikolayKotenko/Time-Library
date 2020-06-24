<template>
    <div id="tags">
        <label :for="tag.id" v-for="tag in tags" v-bind:key="tag.id">
            <input type="radio" :id="tag.id" :value="tag.name" name="tags"><span>{{tag.name}}</span>
        </label>
    </div>
</template>


<script>
    import MainTimeLibraryComponent from "../components/MainTimeLibraryComponent";

    function Tag({ id, name}) {
        this.id = id;
        this.name = name;
    }
    export default {
        data() {
            return {
                tags: [],
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            // async create() {
            //     this.mute = true;
            //     const { data } = await window.axios.get('/api/cruds/create');
            //     this.cruds.push(new Crud(data));
            //     this.mute = false;
            // },
            async read() {
                const { data } = await window.axios.get('/api/tag');
                data.forEach(tag => this.tags.push(new Tag(tag)));
                console.log(data);
            },
            // async update(id, color) {
            //     this.mute = true;
            //     await window.axios.put(`/api/cruds/${id}`, { color });
            //     this.cruds.find(crud => crud.id === id).color = color;
            //     this.mute = false;
            // },
            // async del(id) {
            //     this.mute = true;
            //     await window.axios.delete(`/api/cruds/${id}`);
            //     let index = this.cruds.findIndex(crud => crud.id === id);
            //     this.cruds.splice(index, 1);
            //     this.mute = false;
            // }
        },
        // watch: {
        //     mute(val) {
        //         document.getElementById('mute').className = val ? "on" : "";
        //     }
        // },
        components: {
            MainTimeLibraryComponent
        },
        created() {
            this.read();
        }
    }
</script>
