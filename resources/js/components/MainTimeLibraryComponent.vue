<template>
    <div>WTF</div>
</template>

<script>
    import TagsComponent from "../components/TagsComponent";
    // function Tag({ id, name}) {
    //     this.id = id;
    //     this.name = name;
    // }
    export default {
        data() {
            return {
                tags: TagsComponent,
            }
        },
        mounted() {
            console.log('Component mounted.');
            console.log(TagsComponent);
        },
        // methods: {
        //     // async create() {
        //     //     this.mute = true;
        //     //     const { data } = await window.axios.get('/api/cruds/create');
        //     //     this.cruds.push(new Crud(data));
        //     //     this.mute = false;
        //     // },
        //     async read() {
        //         const { data } = await window.axios.get('/api/tag');
        //         data.forEach(tag => this.tags.push(new Tag(tag)));
        //         console.log(data);
        //     },
        //     // async update(id, color) {
        //     //     this.mute = true;
        //     //     await window.axios.put(`/api/cruds/${id}`, { color });
        //     //     this.cruds.find(crud => crud.id === id).color = color;
        //     //     this.mute = false;
        //     // },
        //     // async del(id) {
        //     //     this.mute = true;
        //     //     await window.axios.delete(`/api/cruds/${id}`);
        //     //     let index = this.cruds.findIndex(crud => crud.id === id);
        //     //     this.cruds.splice(index, 1);
        //     //     this.mute = false;
        //     // }
        // },
        // watch: {
        //     mute(val) {
        //         document.getElementById('mute').className = val ? "on" : "";
        //     }
        // },
        components: {
            TagsComponent
        },
        // created() {
        //     this.read();
        // }
    }
</script>
