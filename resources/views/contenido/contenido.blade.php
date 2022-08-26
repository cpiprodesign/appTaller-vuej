 <!-- Contenido Principal -->
@extends('principal')
 @section('contenido')
 <template v-if="menu==0">
       <dashboard></dashboard>
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
        <!-- /Fin del contenido principal -->
@endsection