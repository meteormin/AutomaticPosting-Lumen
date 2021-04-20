# Change Log

## 2021.04.20
> Version: 0.2.0

- Route 정리
- Absolute 패스 추가
    - Absolute/raw: StockInfo와 Acnt를 단순히 종목 코드만으로 묶어 놓은 결과를 응답
    - Absolute: StockInfo와 Acnt를 하나의 객체로 응답한다.(Acnt데이터에서 필요한 내용만 추출)

- MainService 추가
    - StockInfo(키움 주식 기본정보 데이터 객체), Acnt(open dart 재무제표 데이터 객체) 결합
- PostStockRequest
    - 키움 주가정보 validation 및 변환 클래스
 

## 2021.04.13
> Version: 0.1.0

- Services 추가
    - OpenDartService
    - KoaService
- DtataTransferObjects추가
- Entities제거

## 2021.04.09
> Version: 0.0.2

- 필요 라이브러리 생성
 - Entities
 - Generate
 - JsonMapper
 - OpenDart API 관련 클래스
    - OpenDart Client
 - Client(Laravel Http Client Wrapper)

## 2021.04.08
> Version: 0.0.1
- API 및 인증 모듈 추가

