<template>
    <div id="app" class="container">
        <header id="header">
            <h1>Add note</h1>
            <input type="text" class="form-control" v-model="note.name" placeholder="name source" >
            <textarea class="form-control" v-model="note.desc" cols="30" rows="3" placeholder="description source"></textarea>
        </header>
        <div id="tags">
            <label :for="tag.id" v-for="tag in tags" v-bind:key="tag.id">
                <input type="radio" :id="tag.id" :value="tag.name" v-model="note.tag"><span>{{tag.name}}</span>
            </label>
        </div>
        <div>
            <button @click="create">Add</button>
        </div>

<!--        <span>name: {{note.name}}</span>-->
<!--        <span>desc: {{note.desc}}</span>-->
<!--        <span>tag: {{note.tag}}</span>-->
    </div>
</template>


<script>
    // import MainTimeLibraryComponent from "../components/MainTimeLibraryComponent";

    function Note({id, name, desc, tag}) {
        this.id = id;
        this.name = name;
        this.desc = desc;
        this.tag = tag;
    }
    function Tag({ id, name}) {
        this.id = id;
        this.name = name;
    }
    export default {
        data() {
            return {
                tags: [],
                note: [],
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            async create() {
                console.log(this.note);
                const { data } =
                    await window.axios.post('/api/timelibrary', {
                        name: this.note.name,
                        desc: this.note.desc,
                        tag: this.note.tag,
                    }
                );
                this.note.push(new Note(data));

                console.log(data.name);

                swal({
                    title: "Row added!",
                    text: 'Добавлена в базу запись: \n'+data.name+'\n В теги: '+data.tag,
                    icon: "success",
                    button: "Aww yiss!",
                });


            },
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
        created() {
            this.read();
        }
    }
</script>
