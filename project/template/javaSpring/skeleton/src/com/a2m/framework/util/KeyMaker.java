package com.a2m.framework.util;

public class KeyMaker {
	private String src = "";
    private final String USER_PASSWD_KEY= "PIMS_KEY";
    private String checkKey = "";
    
    private byte permutation[];
    private short i1;
    private short i2;
    
    public KeyMaker() {
    }
	// 암호화 
    public  String  encryptWord(String pw) {       
        this.checkKey = encrypt(this.USER_PASSWD_KEY,this.USER_PASSWD_KEY);
		return encrypt(this.src , this.checkKey);      // 암호화된 패스워드
    }
    
	// 복호화
	public String  decryptWord(String pw) {		
        this.checkKey = encrypt(this.USER_PASSWD_KEY,this.USER_PASSWD_KEY);
		return decrypt(this.src, this.checkKey);                 //정상적인 패스워드
    }


    private  String encrypt(String src, String key) {
    	init(key.getBytes());
        return BASE64Encode(cipher(src.getBytes()));
    }

    /**
     * Simple Decrypt
     * RC4 and BASE64
     */
    private  String decrypt(String src, String key) {
    	init(key.getBytes());
        return new String(cipher(BASE64Decode(src)));
    }

    /**
	 * BASE64 Encode
	 */
    private  String BASE64Encode(byte[] src) {
		sun.misc.BASE64Encoder encoder = new sun.misc.BASE64Encoder();
		return encoder.encode(src);
	}

	/**
	 * BASE64 Decode
	 */
    private  byte[] BASE64Decode(String src) {
		sun.misc.BASE64Decoder decoder = new sun.misc.BASE64Decoder();
		byte[] desc = null;
		try {
			desc = decoder.decodeBuffer(src);
		} catch (Exception e) {
			//
		}
		return desc;
    }
	
	
	private void init(byte abyte0[]) {
		init(abyte0, 0, abyte0.length);
	}
	
	private void init(byte abyte0[], int i, int j) {
        permutation = new byte[256];
        i1 = 0;
        i2 = 0;
        
        for(int k = 0; k < 256; k++){
            permutation[k] = (byte)k;
        }
        
        for(int l = 0; l < 256; l++){
            byte byte0 = permutation[l];
            i2 = (short)((short)(abyte0[i + i1] + byte0) + i2 & 0xff);
            permutation[l] = permutation[i2];
            permutation[i2] = byte0;
            if(j <= ++i1)
                i1 = 0;
        }

        i1 = 0;
        i2 = 0;
    }
	
	private byte[] cipher(byte abyte0[]){
        return cipher(abyte0, 0);
    }
	
    /**
     * @param abyte0[] crypted string
     * @param i start position of crypted string
     */
	private synchronized byte[] cipher(byte abyte0[], int i){
        int j = 0;
        int k = abyte0.length;

        byte[] desc = new byte[k];

        while(k-- > 0){
            i1 = (short)(i1 + 1 & 0xff);
            byte byte0 = permutation[i1];
            i2 = (short)(byte0 + i2 & 0xff);
            byte byte1;
            permutation[i1] = byte1 = permutation[i2];
            permutation[i2] = byte0;
            desc[j++] = (byte)(abyte0[i++] ^ permutation[(short)(byte0 + byte1) & 0xff]);
        }
        i1 = 0;
        i2 = 0;
        
        return desc;
    }

	
}
