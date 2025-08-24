 <!-- Contenido Principal -->
@extends('principal')
 @section('contenido')
 @if(Auth::check())
 @if (Auth::user()->idrol == 1)
     <template v-if="menu==0">
     <dashboard></dashboard>
     {{-- <user></user> --}}
     </template>
     <template v-if="menu==1">
      <orden></orden>
 </template>
 <template v-if="menu==2">
      <cliente></cliente>
 </template>
 <template v-if="menu==3">
      <tecnico></tecnico>
 </template>
 <template v-if="menu==4">
     <reporteOrden></reporteOrden>
</template>
<template v-if="menu==5">
     <user></user>
</template>
<template v-if="menu==6">
     <categoria></categoria>
</template>
<template v-if="menu==7">
     <marca></marca>
</template>
<template v-if="menu==8">
     <articulo></articulo>
</template>
<template v-if="menu==9">
     <proveedor></proveedor>
</template>
<template v-if="menu==10">
     <posventa></posventa>
</template>
     @elseif (Auth::user()->idrol == 2)
         <template v-if="menu==0">
     <ordentecnico></ordentecnico>
     </template>
     <template v-if="menu==1">
      <ordentecnico></ordentecnico>
 </template>
 <template v-if="menu==2">
      <cliente></cliente>
 </template>
 <template v-if="menu==3">
      <tecnico></tecnico>
 </template>
 <template v-if="menu==4">
     <reporteOrden></reporteOrden>
</template>



 @endif

@endif


        <!-- /Fin del contenido principal -->
@endsection
