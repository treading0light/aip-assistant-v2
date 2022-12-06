<template>
	<div id="dropdown" class="dropdown dropdown-end">
	    <label tabindex="0" class="btn btn-ghost rounded-btn"
	    >Recipes</label>
	    <ul tabindex="0" class="menu dropdown-content p-2 shadow bg-base-100 rounded-box w-52 mt-4 text-base">
	      <li><router-link to="/recipe/all">All Recipes</router-link></li>
	      <li><router-link to="/recipe/create">Create New</router-link></li>
	    </ul>
	  </div>
</template>

