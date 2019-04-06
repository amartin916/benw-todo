const newForm = Vue.component('add-new-form',{
  data(){
    return {
      itemText: '',
      placeholderText: [
        'Do the thing!',
        'Take a nap!',
        'Eat some food',
        'Burn off that food',
        'Make that thing!',
        'Write it down!',
        'What needs fixing',
        'What wouldst thou deau?',
      ],
      placeholderToShow: null,
    }
  },
  mounted(){
    this.pickNewPlaceholder();
  },      
  template: `
    <div>
      <input 
        class="newItemInput"
        :placeholder="placeholderText[placeholderToShow]" 
        v-model="itemText"
        @keydown.enter="addNewTodo" />
      <button 
        class="newItemButton"
        type="button"
        @click="addNewTodo">
        Add
      </button>
    </div>
  `,
  methods:{
    pickNewPlaceholder(){
      this.placeholderToShow = Math.floor(Math.random()*this.placeholderText.length);
    },
    addNewTodo(){
      if(this.itemText.trim() == '') return;
      this.$emit("new-todo-item", this.itemText);
      this.itemText = '';
      this.pickNewPlaceholder();
    }
  }
});
const todoItem = Vue.component('todo-item', {
  props: ['todo'],
  data(){
    return{
      mouseIn: false,
      isEditText: false,
      deleteStatus: 0,
      timer: null,
      newText: '',
    }
  },
  mounted(){
    this.newText = this.todo.text;
  },
  computed: {
    colorHash(){
      //awesome hash function I found!
      var hash = 0;
      if (this.todo.text.length == 0) return hash;
      for(char in this.todo.text.split('')){
        hash = char.charCodeAt(0) + ((hash << 3) - hash);
        hash = hash & hash;
      }
      return `hsl(${hash % 360},${this.todo.completed==null?85:25}%,70%)`;
    },
    isDone(){
      return this.todo.completed != null;
    }
  },
  template: `
    <div class="todoItem" 
      @mouseover="mouseIn = true" 
      @mouseout="mouseIn=false"
      :style="{backgroundColor:colorHash, color: isDone?'grey':'black'}">

      <div :class="{todoItemText: true, todoItemDone: isDone}">
        <div style="padding: 4px 5px;"
          @dblclick="showEdit" 
          v-show="!isEditText">
          {{todo.text}}
        </div>
        <textarea type="text" class="editTodoTextInput" 
          style="width:100%; padding: 0px 5px; margin: 4px 0px;"
          ref="editTodoText"
          v-model="newText" 
          @keydown.enter="updateValue" 
          @blur="updateValue" 
          v-show="isEditText"/>
      </div>

      <div class="todoItemActions">
          <span class="todoItemCheck" v-show="!isDone && mouseIn" @click="completeMe">
            <i class="material-icons">check</i>
          </span>
          <span v-show="isDone && mouseIn" @click="deleteMe">
            <i :class="{'material-icons':true, 'deleteWarn':deleteStatus==1}">delete</i>
          </span>
      </div>

    </div>
  `,
  methods:{
    showEdit(){
      this.isEditText=true; 
      this.$nextTick(() => {
        this.$refs.editTodoText.focus();
        this.$refs.editTodoText.style.height = this.$refs.editTodoText.scrollHeight+"px";
      });
    },
    updateValue(){
      this.isEditText = false;
      this.$set(this.todo, 'text', this.newText);
    },
    completeMe(){
      this.$set(this.todo, 'completed', +new Date());
    },
    deleteMe(){
      clearTimeout(this.timer);
      if(this.deleteStatus == 1){
        this.deleteStatus = 0;
        this.$emit('delete', this.todo.id);
      }else{
        this.timer = setTimeout(() => {
          this.deleteStatus = 0;
        }, 800);
        this.deleteStatus = 1;
      }
    }
  },
});