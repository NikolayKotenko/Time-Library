<div id="app" class="container">
    <a v-link="{ path: '/' }"><h1>Our company</h1></a>
    <ul class="navigation">
        <li><a v-link="{ path: '/edit' }">People</a></li>
    </ul>
    <router-view></router-view>
</div>



<script>
    // import FormAddRecord from "./components/FormAddRecord.vue";
    // import FormEditRecord from "./components/FormEditRecord";
    // // import TagsDynamicBlockCalcTime from "./components/TagsDynamicBlockCalcTime.vue";
    //
    // export default {
    //     data(){
    //         return{
    //
    //         }
    //     },
    //     components:{
    //         FormAddRecord,
    //         FormEditRecord,
    //         // TagsDynamicBlockCalcTime,
    //     }
    // }
</script>
