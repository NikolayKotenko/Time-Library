<template>
    <nav id="vue_navbar" class="navbar navbar-expand-lg navbar-light bg-white">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <router-link :to="{name: 'add'}" class="nav-link">Add</router-link>
                </li>
                <li class="nav-item">
                    <router-link :to="{name: 'edit'}" class="nav-link">Edit</router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>
