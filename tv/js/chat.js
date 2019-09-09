const arraystickers=['stickHello.png','stickSad.png','stickCry.gif','stickOoo.png','stickNos.png','stickShit.png','stickMoney.png','stickDurak.gif',
'stickShit1.png',
'stickShit2.png',
'stickShit3.png',
'stickShit4.png',
'stickShit5.png',
'stickShit6.png',
'stickNew1.png',
'stickNew2.gif'];


function insertAtCursor(myField, myValue) {
    //IE support
    if (document.selection) {
        //myField.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
    }
    //MOZILLA and others
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        myField.value = myField.value.substring(0, startPos)
            + myValue
            + myField.value.substring(endPos, myField.value.length);
    } else {
        myField.value += myValue;
    }
}



function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function checkIgnore(row) {
  return row[''] >= 18;
}


function AddMessage(array,addarray){
  resultA=array;
  resultA=resultA.concat(addarray);
  if (resultA.length>40)
    resultA.splice(0,resultA.length-40);
  return resultA;
}

class Messages extends React.Component {
  constructor(props) {
    super(props);
    this._isMounted = false;
    this.state = {
      array: [],
      isLoading: true,
      error: null,
      index: -1,
      array_to_block: [],
    };
    this.array_users= [];
    this.value='';
    this.curindex=0;
    this.SendEvent = this.SendEvent.bind(this);
    this.ClickButton = this.ClickButton.bind(this);
    this.ScrollEvent = this.ScrollEvent.bind(this);
    this.KeyDown = this.KeyDown.bind(this);
    this.KeyPress = this.KeyPress.bind(this);
    this.UpdateResArray = this.UpdateResArray.bind(this);
    this.HideBlock = this.HideBlock.bind(this);
    this.ClickHelpUser = this.ClickHelpUser.bind(this);
        this.HoverChange = this.HoverChange.bind(this);
  }
  componentWillMount() {
    this.interval=setInterval(this.DoQuery.bind(this),3000);

  }
  SendEvent(){
    if (!this.state.isLoading){
    const message=$("#input_chat_text").val();
    if (message!=''){
    $('#send_message_chat').attr('disabled','disabled');
    $('#input_chat_text').attr('disabled','disabled');
    $('#input_chat_text').val('');
    var data=new FormData();
    if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
    data.append('message',message);
      fetch('https://api.shass.ru/live/message.php?event=send&login='+login,{
        method: 'POST',
        body: data
      })
      .then(response => {
          $('#send_message_chat').removeAttr('disabled');
          $('#input_chat_text').removeAttr('disabled');
          if (response.ok) {
              return response.json();
            } else {
              throw new Error('Error query');
            }
          })
        .then( data =>{
          if (this._isMounted) {
          this.DoQuery();
          if (!data['status']){
            this.setState({ array: AddMessage(this.state.array,{tech: true, message: 'Ваше сообщение не было отправлено'}) });
          }
        }
      }
        )
        .catch(error => {
            this.setState({ array: AddMessage(this.state.array,{tech: true, message: 'Ваше сообщение не было отправлено'}) });
          $('#send_message_chat').removeAttr('disabled');
          $('#input_chat_text').removeAttr('disabled');
        });
      }
    }
  }
  DoQuery(){
    const {index,array,isLoading} = this.state;
      fetch('https://api.shass.ru/live/message.php?from='+index+'&event=get&login='+login)
      .then(response => {
          if (response.ok) {
              return response.json();
            } else {
              throw new Error('Error query');
            }
          })
        .then( data =>{
          if (this._isMounted) {
          if (data['status']){
            if (data['result']){
            var arrayListUsers=this.array_users;
            var bufArray=(data['result'].filter(function(a){
              if (arrayListUsers.findIndex(x=>
                x==a['type']+a['login'])===-1)
              return true;
            }));
            bufArray=bufArray.map(function(a){ return a['type']+a['login'] });
            if (bufArray)
            this.array_users=this.array_users.concat(bufArray);
          }
            if (isLoading) this.setState({ isLoading: false });
            if (data['index'] && data['result'])
            this.setState({ index: data['index'],array: AddMessage(array,data['result']) });
            else
            if (data['index']) this.setState({ index: data['index'] });
            else
            if (data['result'])
            this.setState({ array: AddMessage(array,data['result'])})
          }else  this.setState({ array: AddMessage(array,{tech: true, message: data['error']})});
        }
      }
        )
        .catch(error => this.setState({ array: AddMessage(array,{tech: true, message: error})}));
  }
  componentDidMount() {
    this._isMounted = true;
    this.DoQuery();
    this.scrollToBottom();
    $("#send_message_chat").click(this.SendEvent);
    $("#button_scroll_auto").click(this.ClickButton);
    $("#chat-app").scroll(this.ScrollEvent);
    $('#input_chat_text').keydown(this.KeyDown);
        $('#input_chat_text').keypress(this.KeyPress);
                $('#input_chat_text').focusout(this.HideBlock);
  }
  ScrollEvent() {
    var element = document.getElementById("chat-app");
    const height=element.scrollHeight-element.clientHeight-element.scrollTop
    if (height>10)
      {
        $('#button_scroll_auto').show();
        this.stopScrooll=true;
      }else if(height==0){
        this.stopScrooll=false;
        this.scrollToBottom();
        $('#button_scroll_auto').hide();
      }
  }
  ClickButton() {
        this.stopScrooll=false;
        this.scrollToBottom();
        $('#button_scroll_auto').hide();
  }
  KeyDown(e) {
    if (e.keyCode === 13 && $('#input_chat_text').val()!='') { // If Enter key pressed
      if(($("#help_users").is(":visible"))){
        const textTosearch=this.value;
        var resSearch=this.array_users.filter(function(a){ return a.startsWith(textTosearch); });
        if (resSearch && resSearch.length>0){
                insertAtCursor($('#input_chat_text')[0],resSearch[this.curindex].replace(this.value,'')+' ');
      //  $('#input_chat_text').val($('#input_chat_text').val()+resSearch[this.curindex].replace(this.value,'')+' ');
        this.HideBlock();
        }else {
          $('#send_message_chat').click();
        $('#input_chat_text').val('');}
      }else{
        $('#send_message_chat').click();
        $('#input_chat_text').val('');
      }
    }
    if(e.keyCode === 13 || e.keyCode ===32 || e.keyCode ===37|| e.keyCode ===39)
    {
      this.HideBlock();
    }
    if(e.keyCode === 40 && ($("#help_users").is(":visible")))
    {
      if (this.curindex>=this.array_users.length || this.curindex<0)this.curindex=0;
      if(this.curindex<this.array_users.length-1)
      this.curindex+=1;
      else this.curindex=0;
      this.UpdateResArray();
    }
    if(e.keyCode === 38 && ($("#help_users").is(":visible")))
    {
      if (this.curindex>=this.array_users.length || this.curindex<0)this.curindex=0;
      if(this.curindex>0)
      this.curindex-=1;
      else if (this.array_users.length>0) this.curindex=this.array_users.length-1;
      else this.curindex=0;
      this.UpdateResArray();
    }
    if (e.keyCode === 8) { // If Enter key pressed
      if (this.value=='')$('#help_users').hide();
      else{
        this.value=this.value.slice(0, -1);
        this.UpdateResArray();
      }
    }
  }
  ClickHelpUser(index){
    var index_=$(index.currentTarget).attr('index');
    if (index_>=this.array_users.length || index_<0)index_=0;
    const textTosearch=this.value;
    var resSearch=this.array_users.filter(function(a){ return a.startsWith(textTosearch); });
    if (resSearch && resSearch.length>0){
      insertAtCursor($('#input_chat_text')[0],resSearch[index_].replace(this.value,'')+' ');
      //$('#input_chat_text').val($('#input_chat_text').val()+resSearch[index_].replace(this.value,'')+' ');
  }
    this.HideBlock();
  }
  HoverChange(e){
    var index_=$(e.currentTarget).attr('index');
    $( ".span-help-users" ).each(function( index ) {
      if (index==index_)
      $(this).addClass('span-help-users-select');
      else $(this).removeClass('span-help-users-select');
    });
  }
  HideBlock(e){
    if ($("#help_users").is(":visible") && (!e || !e.relatedTarget || !$(e.relatedTarget).hasClass('span-help-users'))){
    this.curindex=0;
    this.value='';
    $('#help_users').hide();
  }
  }
  UpdateResArray(){
    if ($("#help_users").is(":visible")) {
      const textTosearch=this.value;
      var resSearch=this.array_users.filter(function(a){ if (a.startsWith(textTosearch)) return a; });
      resSearch=resSearch.slice(0,5);
      var _index=this.curindex;
      var handler=this.ClickHelpUser;
      var handler1=this.HoverChange;
      var elements=resSearch.map(function(a,index){  if (index==_index) {
        var newDiv=document.createElement("button");
        newDiv.innerHTML = a;
        newDiv.className="span-help-users span-help-users-select";
        newDiv.addEventListener("click", handler);
        newDiv.setAttribute('index', index);
        $(newDiv).hover(handler1);
        return newDiv;
      }
    else{
      var newDiv=document.createElement("button");
      newDiv.innerHTML = a;
      newDiv.className="span-help-users";
      newDiv.addEventListener("click", handler);
      newDiv.setAttribute('index', index);
      $(newDiv).hover(handler1);
      return newDiv;
    }
  });

      if (elements.length==0){
        //this.HideBlock();
        var newDiv=document.createElement("div");
        newDiv.innerHTML = 'Ничего не найдено';
        elements=newDiv;
      }
      $("#help_users").html('');
      $("#help_users").append(elements);
    }
  }
  KeyPress(e){
    if (e.key=='@' && !$("#help_users").is(":visible") ){
        $('#help_users').show();
        this.UpdateResArray();
    }else if ($("#help_users").is(":visible")) {
      this.value+=e.key;
      this.UpdateResArray();
    }
  }

  componentWillUnmount() {
  this._isMounted = false;
  clearInterval(this.interval);
  $("#send_message_chat").prop("onclick", null).off("click");
  $("#button_scroll_auto").prop("onclick", null).off("click");
  $("#chat-app").off("scroll", this.ScrollEvent);
  $("#input_chat_text").off("keydown", this.KeyDown);
    $("#input_chat_text").off("focusout", this.HideBlock);
}

scrollToBottom() {
  if(!this.stopScrooll){
  var element = document.getElementById("chat-app");
  element.scrollTop = element.scrollHeight;
}
}


componentDidUpdate() {
  this.scrollToBottom();
}
  render() {
    const { array, isLoading, error,array_to_block } = this.state;

    if (error) {
      return React.createElement('div', null,error);
    }

  if (isLoading) {
    return React.createElement('div', {className: 'loader'},null);
  }

  const arrayList = array.map(function(row,index){
                  if (!row['tech']){
                  if(array_to_block.findIndex(x => x['type']==row['type'] && x['login']==row['login'])==-1){
                  if (row['login']==login && row['type']=='SELF'){
                    if (row['message'].split(' ').indexOf('@'+typeAuth+dispName)==-1)
                  return React.createElement('div',{key:row['ID_MESSAGE'],className: 'main-message-block-chat'}, [
                  React.createElement('span',{key:row['ID_MESSAGE']+'STREAMER',className: 'login-message-chat-icon',style: {backgroundImage: 'url(/images/streamer.png)'}},null),
                  React.createElement('span',{key:row['ID_MESSAGE']+'STREAMER',className: 'login-message-chat-icon',style: {backgroundImage: 'url(/images/self.png)'}},null),
                  React.createElement('span',{key:row['ID_MESSAGE']+'ICON',className: 'login-message-chat',style: {color: row['color']}},row['login']),
                  React.createElement('span',{key:row['ID_MESSAGE']+'MESSAGE'},(': '+row['message']).split(' ').filter(function(value__){return value__!='';}).map(function(a,index){
                    if (arraystickers.indexOf(a.trim()+'.png')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.png')],alt: a},null);
                    else if (arraystickers.indexOf(a.trim()+'.gif')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.gif')],alt: a},null);
                    else return React.createElement('span',{key:index+'WORD'},a+' ');
                  }))]);
                  else
                return React.createElement('div',{key:row['ID_MESSAGE'],className: 'main-message-block-chat-to-you'}, [
                React.createElement('span',{key:row['ID_MESSAGE']+'STREAMER',className: 'login-message-chat-icon',style: {backgroundImage: 'url(/images/streamer.png)'}},null),
                React.createElement('span',{key:row['ID_MESSAGE']+'STREAMER',className: 'login-message-chat-icon',style: {backgroundImage: 'url(/images/self.png)'}},null),
                React.createElement('span',{key:row['ID_MESSAGE']+'ICON',className: 'login-message-chat',style: {color: row['color']}},row['login']),
                React.createElement('span',{key:row['ID_MESSAGE']+'MESSAGE'},(': '+row['message']).split(' ').filter(function(value__){return value__!='';}).map(function(a,index){
                  if (arraystickers.indexOf(a.trim()+'.png')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.png')],alt: a},null);
                  else if (arraystickers.indexOf(a.trim()+'.gif')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.gif')],alt: a},null);
                  else return React.createElement('span',{key:index+'WORD'},a+' ');
                }))]);
                }
                  else {
                  var typeOfIconUrl='url(/images/self.png)';
                  switch(row['type']){
                    case 'YANDEX':
                        typeOfIconUrl='url(/images/yandex.png)';
                    break;
                    case 'VK':
                        typeOfIconUrl='url(/images/vk.png)';
                    break;
                    case 'TWITCH':
                        typeOfIconUrl='url(/images/twitch.png)';
                    break;
                  }
                  if (row['message'].split(' ').indexOf('@'+typeAuth+dispName)==-1)
                  return React.createElement('div',{key:row['ID_MESSAGE'],className: 'main-message-block-chat'}, [
                  React.createElement('span',{key:row['ID_MESSAGE']+'STREAMER',className: 'login-message-chat-icon',style: {backgroundImage: typeOfIconUrl}},null),
                  React.createElement('span',{key:row['ID_MESSAGE']+'ICON',className: 'login-message-chat',style: {color: row['color']}},row['login']),
                  React.createElement('span',{key:row['ID_MESSAGE']+'MESSAGE'},(': '+row['message']).split(' ').filter(function(value__){return value__!='';}).map(function(a,index){
                    if (arraystickers.indexOf(a.trim()+'.png')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.png')],alt: a},null);
                    else if (arraystickers.indexOf(a.trim()+'.gif')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.gif')],alt: a},null);
                    else return React.createElement('span',{key:index+'WORD'},a+' ');
                  }))]);
                  else
                  return React.createElement('div',{key:row['ID_MESSAGE'],className: 'main-message-block-chat-to-you'}, [
                  React.createElement('span',{key:row['ID_MESSAGE']+'STREAMER',className: 'login-message-chat-icon',style: {backgroundImage: typeOfIconUrl}},null),
                  React.createElement('span',{key:row['ID_MESSAGE']+'ICON',className: 'login-message-chat',style: {color: row['color']}},row['login']),
                  React.createElement('span',{key:row['ID_MESSAGE']+'MESSAGE'},(': '+row['message']).split(' ').filter(function(value__){return value__!='';}).map(function(a,index){
                    if (arraystickers.indexOf(a.trim()+'.png')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.png')],alt: a},null);
                    else if (arraystickers.indexOf(a.trim()+'.gif')!=-1)  return React.createElement('img',{key:index+'WORD',className: 'sticker', src: '/images/stickers/'+arraystickers[arraystickers.indexOf(a.trim()+'.gif')],alt: a},null);
                    else return React.createElement('span',{key:index+'WORD'},a+' ');
                  }))]);
                }
              }
                }
                  else
                  return React.createElement('div',{key:row['TECH']+index,className: 'tech-message'}, row['message']);
  });

  return arrayList;

  }
}
