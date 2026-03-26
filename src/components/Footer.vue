<template>
  <footer class="footer">
    <div class="info-section">
      <div class="container">
        <h2 class="footer-title">Быть лучше каждый день</h2>
        <p class="footer-text">
          Более 1 месяца интернет-магазин AVE SHOP предлагает клиентам лучшие смартфоны  
          по выгодным ценам. Я постоянно работаю над качеством сервиса, чтобы ваши покупки были 
          максимально комфортными и быстрыми.
        </p>
      </div>
    </div>

    <div class="bottom-bar">
      <div class="container bar-flex">
        <div class="copyright">
          © 2026 AVE SHOP. Все права защищены.
        </div>
        <div class="author">
          Автор сайта: <span class="author-name">Аверин Никита</span>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer {
  background: #fff;
  margin-top: 60px;
  font-family: Arial, sans-serif;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.info-section {
  padding: 40px 0;
  background: #f8f9fa;
  border-top: 1px solid #eee;
}

.footer-title {
  font-size: 24px;
  color: #3d497b; 
  margin-bottom: 20px;
  font-weight: bold;
}

.footer-text {
  font-size: 14px;
  line-height: 1.6;
  color: #666;
  max-width: 800px;
  margin-bottom: 15px;
}

.bottom-bar {
  background: #3d497b;
  color: #f6f3ee;
  padding: 25px 0;
}

.bar-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 14px;
}

.author-name {
  color: #e6652f;
  font-weight: bold;
}

.copyright {
  opacity: 0.8;
}
</style>