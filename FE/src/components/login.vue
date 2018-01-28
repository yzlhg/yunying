<template>
  <div></div>
</template>

<script>
  export default {
    data() {
      return {
        
      }
    },
    created() {
        this.$prompt('请输入授权码','', {
          confirmButtonText: '确定',
          showCancelButton:false,
          center: true
        }).then(({ value }) => {
          this.$post('/Index/auth',{
            authCode:value
          }).then(response => {
            localStorage.setItem('toKey',response);
            if(response == 'error'){
              this.$message({
                type:'error',
                message:'授权码错误！',               
              });
              this.callback(window.location.href='/#/login')
            }else{
              this.$message({
                type:'success',
                message:'授权码正确！'
              });
             this.callback(window.location.href='/')              
            }
          })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '取消输入'
          });       
        });
    }
  }
</script>
<style>
  .el-message-box{
    width:auto;
  }
</style>