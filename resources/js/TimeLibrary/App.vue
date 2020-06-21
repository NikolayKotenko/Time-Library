<div id="app">
    <div id="example-1">
        <button v-on:click="counter += 1">+1</button>
        <p>Кнопка выше была нажата {{ counter }} раз</p>
    </div>
</div>

<script>
    var example1 = new Vue({
        el: '#example-1',
        data: {
            counter: 0
        }
    })
</script>
