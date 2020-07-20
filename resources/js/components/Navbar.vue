<template>
    <nav id="vue_navbar" class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link :to="{name: 'add'}" class="nav-link">Add</router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'edit'}" class="nav-link">Table</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>
