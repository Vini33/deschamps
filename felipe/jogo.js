var coo = document.cookie
var sem = coo.slice(10,coo.length)

loop()
function loop(){
    var nav = document.querySelector('nav')
    var canvas = document.querySelector('canvas')
    var ctx = canvas.getContext('2d')

    var player = {playerId:{}, fruit:{}}
    function desenha(){
        ctx.fillStyle = 'white'
        ctx.clearRect(0,0,20,20)
        
        for(const play in player.playerId){
            const playe = player.playerId[play]
            ctx.fillStyle = '#CCC'
            ctx.fillRect(playe.pos_x,playe.pos_y,1,1)
            if(playe.user_id == sem){
                ctx.fillStyle = '#F0DB4F'
                ctx.fillRect(playe.pos_x,playe.pos_y,1,1)
            }
        }
        for(const fruit in player.fruit){
            const fru = player.fruit[fruit]
            ctx.fillStyle = 'green'
            ctx.fillRect(fru.p_x,fru.p_y,1,1)
        }
        for(var i = 0;i< player.playerId.length; i++){
            if(i == player.playerId.length){
                break
            }
            //console.log(i)
        }
    }
    function looop(){
        $.ajax({
            url: 'http://localhost/felipe/play.php',
            method:'POST',
            dataType: 'json',
        }).done(function(e){
            player.playerId = e[0]
            player.fruit = e[1]
        })
        window.requestAnimationFrame(looop,canvas)
        desenha()
    }
    looop()
}

document.addEventListener('keydown',tleca)

function tleca(event){
    const keyPress = event.key 

    $.ajax({
        url: 'http://localhost/felipe/upp.php',
        method:'POST',
        data:{press:keyPress},
        async:false,
        dataType: 'json',
    })
}
